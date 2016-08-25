<?php
namespace App\Services\Project;

use App\Models\ProjectExpertModel;
use App\Models\UserExpertModel;
use App\Models\UserInfoModel;
use App\Services\Base\BaseProcess;

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
class Expert extends BaseProcess {
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
        if( ! $this->objModel) $this->objModel = new ProjectExpertModel();
    }
    
    public function search(array $search,array $orderby=array('sort','desc'),$pagesize=PAGE_NUMS) 
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('title', 'like', $keywords);
            });
        }
        
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }
        
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }

    public function getByProject($project_id,$user_id=null) {
        $currentQuery = $this->objModel->select("project_expert.*",
                                "user_info.avater",
                                "user_info.name",
                                "user_info.mobile",
                                "user_expert.position",
                                \DB::raw("user_expert.gov_score as user_gov_score"),
                                "user_expert.academy",
                                "user_expert.education"
        );


        $currentQuery = $currentQuery->where("project_id",$project_id);
        if($user_id) {
            $currentQuery = $currentQuery->where("project_expert.user_id",$user_id);

        }
        $currentQuery = $currentQuery->leftJoin("user_info","user_info.id","=","project_expert.user_id");
        $currentQuery = $currentQuery->leftJoin("user_expert","user_expert.user_id","=","project_expert.user_id");
        $data =  $currentQuery->get();
        foreach($data as &$val) {
            $val['projectInfo'] = $this->getUserProject($val->user_id,$val->project_id);
        }
        return $data;
    }

    public function getUserProject($user_id,$excludeId=null) {
        $currentQuery = $this->objModel->select("project_info.id","project_info.name");
        $currentQuery = $currentQuery->leftJoin("project_info","project_info.id","=","project_expert.project_id");
        $currentQuery = $currentQuery->where("project_expert.user_id",$user_id);
        if($excludeId) {
            $currentQuery = $currentQuery->where("project_expert.id",'<>',$excludeId);

        }
        $currentQuery = $currentQuery->groupBy("project_expert.project_id");
        $data = $currentQuery->get();
        return $data;
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
        return $this->objModel->find($id);
    }
    
    /**
     * 添加
     * @param unknown $data
     */
    public function create($project_id,$user_id,$territory='')
    {
        //搜索用户

        $objUser = new UserExpertModel();
        $user = $objUser->find($user_id);
        if(!$user) {
            $this->setMsg('没有找到用户');
            return false;
        }

        //查找用户添加了几次
        $ok = $this->objModel->where("project_id",$project_id)->where("user_id",$user->user_id)->count();

        if($ok>1) {
            $this->setMsg('同一个专家最多添加二次!!!');
            return false;
        }
        if($ok==1) {
            if($territory=="") {
                $this->setMsg('该专家已被添加一次，二次添加必须手动选择领域');
                return false;
            }
            $ok = $this->objModel->where("project_id",$project_id)->where("user_id",$user->user_id)->where("territory",$territory)->count();
            if($ok) {
                $this->setMsg('同一个领域只能被添加一次');
                return false;
            }

        }

        $addData['project_id'] = $project_id;
        $addData['user_id'] = $user->user_id;
        $addData['territory'] = $territory;
        if(!$addData['territory']) {
            $addData['territory'] = $user->territory;
        }
        $ok =  $this->objModel->create($addData);
        if($ok) {
            (new Project())->dealNotice($project_id,'notice_project_export');
        }
        return $ok;
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
            $this->setMsg("未找到！");
            return false;
        }
        

        $ok = $obj->update($data);
        (new Project())->dealNotice($obj->project_id,'notice_project_export');

        //更新评分
        $govScore = $this->objModel->where('user_id',$obj->user_id)->avg('gov_score');
        $userExpertObj = new UserExpertModel();
        $userInfo = $userExpertObj->find($obj->user_id);
        $userInfo->gov_score = round($govScore,2);
        $userInfo->save();
        return $ok;
    }
    
    /**
     * 删除
     * @param unknown $id
     */
    public function destroy($id)
    {
        $obj = $this->objModel->find($id);
        if($obj) {
            (new Project())->dealNotice($obj->project_id,'notice_project_export');
             return $this->objModel->destroy($id);

        }else{
            $this->setMsg('没有找到数据');
            return false;
        }

    }
    
    
}
