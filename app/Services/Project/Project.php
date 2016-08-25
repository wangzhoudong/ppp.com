<?php
namespace App\Services\Project;

use App\Models\ProjectExpertModel;
use App\Models\ProjectInfoModel;
use App\Models\UserInfoModel;
use App\Services\Base\BaseProcess;
use App\Models\CmsVideoModel;

/**
 * 
 *--------------------------------------------------------------------------
 * 
 *--------------------------------------------------------------------------
 *
 * @author wangzhoudong
 * @version V1.0
 *
 */
class Project extends BaseProcess {
    /**
     * 模型
     *
     * @var object
     * 
     */
    private $objModel;
    
    /**
     * 初始化
     *
     * @access public
     * 
     */
    public function __construct()
    {
        if( ! $this->objModel) $this->objModel = new ProjectInfoModel();
    }
    
    public function search(array $search,array $orderby=array('created_at'=>'desc'),$pagesize=PAGE_NUMS)
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('name', 'like', $keywords)
                 ->orWhere('operating_taxes', 'like', $keywords);
            });
        }
        if(isset($search['status']) && !empty($search['status'])) {
            $currentQuery = $currentQuery->where('status',$search['status']);
        }

        if(isset($search['type']) && !empty($search['type'])) {
            $currentQuery = $currentQuery->where('type',$search['type']);
        }
        if(isset($search['greaterStatus']) && !empty($search['greaterStatus'])) {
            $currentQuery = $currentQuery->where('status',">=",$search['greaterStatus']);
        }
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }
        
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }

    public function getAll(array $search,array $orderby=['created_at'=>'desc'],$pagesize=PAGE_NUMS)
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('title', 'like', $keywords)
                    ->orWhere('link', 'like', $keywords);
            });
        }
        if(isset($search['type']) && !empty($search['type'])) {
            $department_ids = $search['type'];
            $currentQuery = $currentQuery->where('type',$search['type']);
        }
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }

        $currentQuery = $currentQuery->take($pagesize)->get();
        return $currentQuery;
    }
    
    public function get($where) {
        //条件
        $currentQuery = $this->objModel;
        if($where && is_array($where)){
            foreach ($where AS $field => $value){
                $currentQuery = $currentQuery -> where($field, $value);
            }
        }
    
        return $currentQuery->first();
    }
    
    public function find($id) {
        $data =   $this->objModel->find($id);
        return $this->dealData($data);
    }
    //获取政府的项目数
    public function getByGov($uid) {
        //获取政府的项目数
        $data =  $this->objModel->where('user_id',$uid)->get();
        return $data;
    }

    //获取专家的项目数
    public function getByExpert($uid) {
        //获取专家的项目
        $obj = new ProjectExpertModel();
        $aProjectId = $obj->select('project_id')->where("user_id",$uid)->groupBy('project_id')->lists("project_id");
        $data = $this->objModel->whereIn("id",$aProjectId)->get();
        return $data;

    }

    public function dealData($data) {
        if($data){
            if($data->recent_5_year) {
                $data['recent_5_yearInfo'] = json_decode($data->recent_5_year,true);
            }
            if($data->item_project) {
                $data['item_projectInfo'] = json_decode($data->item_project,true);
            }
            if($data->cooperation_year) {
                $data['cooperation_yearInfo'] = json_decode($data->cooperation_year,true);
            }
            if($data->supporting_plan) {
                $data['supporting_planInfo'] = json_decode($data->supporting_plan,true);
            }
            if($data->counseling_times) {
                $data['counseling_timesInfo'] = explode(',',$data->counseling_times);
            }
            if($data->other_info_file) {
                $data['other_info_fileInfo'] = json_decode($data->other_info_file,true);

            }
            if($data->project_financial) {
                $data['project_financialInfo'] = json_decode($data->project_financial,true);
            }else{
                $data['project_financialInfo'] = [['repay'=>'',
                    'estimation'=>'',
                    'annual_operating_cost'=>'',
                    'annual_operating_income'=>'',
                    'cooperation_year_operation'=>'',
                    'cooperation_year_name'=>'',
                    'subname'=>'']];
            }
        }
        return $data;
    }

    /**
     * 添加
     * @param unknown $data
     */
    public function create($data)
    {
        $data = $this->dealPostData($data);
        $data['status'] = 1;//草稿

        $ok =  $this->objModel->create($data);

        if($ok) {
            return $ok;
        }else{
            $this->setMsg('创建项目失败');
            return false;
        }

    }
    
    /**
     * 更新
     * @param unknown $id
     * @param unknown $data
     */
    public function update($id,$data)
    {
        $obj = $this->objModel->find($id);
        if(!$obj) {
            $this->setMsg("未找到【{$id}】信息！");
            return false;
        }
        $data = $this->dealPostData($data);
        $ok = $obj->update($data);
        //处理通知
        $this->dealNotice($id,'notice_project_detail');
        return $ok;
    }


    public function dealNotice($projectId,$type='notice_project_detail') {
        $project = $this->objModel->find($projectId);
        //查询政府人员
        $userid[] = $project->user_id;
        //查询专家
        $objExport = new ProjectExpertModel();
        $exportUser = $objExport->select("user_id")->where("project_id",$project->id)->get();
        if($exportUser) {
            foreach($exportUser as $val) {
                $userid[] = $val->user_id;
            }
        }


        $userObj = new UserInfoModel();
        $userObj = $userObj->whereIn("id",$userid);
        $user = session(LOGIN_MARK_SESSION_KEY);

        if($user) {
            $userObj->where("id","<>",$user['id']);
        }
        $userObj->update([$type=>1]);



    }
    /**
     * 更新状态
     * @param $id
     * @param $status
     */
    public function updateStatus($id, $status)
    {
        $data = $this->objModel->find($id);
        $data->status = $status;
        return $data->save();
    }


    /**
     * 更新类型
     * @param $id
     * @param $status
     */
    public function updateType($id, $type)
    {
        $data = $this->objModel->find($id);
        $data->type = $type;
        return $data->save();
    }
    public function dealPostData($data) {

        //近五年预算执行情况
        if(isset($data['recent_5_year']) && $data['recent_5_year']) {
            $arr = [];
            foreach($data['recent_5_year']['expend'] as $key=>$val) {
                $arr[$key] = ['expend'=>$val,
                            'income'=>$data['recent_5_year']['income'][$key]
                            ];
                $arr[$key]['count'] = $arr[$key]['expend'] - $arr[$key]['income'];
            }
            $data['recent_5_year'] = json_encode($arr);
        }
        //已批复的PPP项目以及占用资金
        if(isset($data['item_project']) && $data['item_project']) {
            $arr = [];
            $afterYear = afterYear(30);
            foreach($data['item_project']['name'] as $key=>$val) {
                $arr[$key]['name'] = $val;
                foreach($afterYear as $year) {
                    $arr[$key]['year'][$year] = isset($data['item_project']['year'][$year][$key]) ? $data['item_project']['year'][$year][$key] : "";
                }
            }
            $data['item_project'] = json_encode($arr);
        }
        //合作年限：
        if(isset($data['cooperation_year']) && $data['cooperation_year']) {
            $arr = [];
            foreach($data['cooperation_year']['name'] as $key=>$val){
                $arr[] = [
                    'name'=>$val,
                    'construction'=>$data['cooperation_year']['construction'][$key],
                    'operation'=>$data['cooperation_year']['operation'][$key],
                ];
            }
            $data['cooperation_year'] = json_encode($arr);
        }
        //总投资之外，项目建设期政府提供的相关配套金额及投入计划：
        if(isset($data['supporting_plan']) && $data['supporting_plan']) {

            $arr = [];
            $afterYear = afterYear(30);
            foreach($data['supporting_plan']['count'] as $key=>$val) {
                $arr[$key]['count'] = $val;
                foreach($afterYear as $year) {
                    $arr[$key]['year'][$year] = isset($data['supporting_plan']['year'][$year][$key]) ?$data['supporting_plan']['year'][$year][$key] :"";
                }
            }

            $data['supporting_plan'] = json_encode($arr);
        }
        if(isset($data['financing_proportion_zf']) && isset($data['financing_proportion_sh'])) {
            $data['financing_proportion'] = $data['financing_proportion_zf'] +
                $data['financing_proportion_sh'] +
                $data['financing_proportion_xm'];
        }

        if(isset($data['place_area_id']) && isset($data['place_area_id'])) {
            $data['place'] = dict()->areaName($data['place_area_id']);
        }
        //财务信息
        if(isset($data['project_financial']) && $data['project_financial']) {
            $arr = [];
            foreach($data['project_financial']['subname'] as $key=>$val){
                $arr[] = [
                    'subname'=>$val,
                    'estimation'=>$data['project_financial']['estimation'][$key],
                    'annual_operating_cost'=>$data['project_financial']['annual_operating_cost'][$key],
                    'annual_operating_income'=>$data['project_financial']['annual_operating_income'][$key],
                    'cooperation_year_operation'=>$data['project_financial']['cooperation_year_operation'][$key],
                    'cooperation_year_name'=>$data['project_financial']['cooperation_year_name'][$key],
                    'repay'=>$data['project_financial']['repay'][$key],

                ];

            }
            $data['project_financial'] = json_encode($arr);
        }

        return $data;
    }
    
    /**
     * 删除
     * @param unknown $id
     */
    public function destroy($id)
    {
        return $this->objModel->destroy($id);
    }
    
    
}
