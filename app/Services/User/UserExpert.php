<?php
/**
 *  专家用户用户操作
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年11月13日
 *
 */
namespace App\Services\User;
use Hash;
use App\Services\Base\BaseProcess;
use App\Models\UserInfoModel;
use App\Models\UserExpertModel;

class UserExpert extends BaseProcess
{
    /**
     * 模型
     *
     * @var object
     *
     */
    private $_objModel;
    
    private $_userModel;

    /**
     * 初始化
     */
    public function __construct()
    {
        if( !$this->_objModel) $this->_objModel = new UserExpertModel();
        if( !$this->_userModel) $this->_userModel = new UserInfoModel();
    }
    
   
    /**
     * 搜索
     * @param $search
     * @param $pagesize
     */
    public function search($search, $orderby = array(), $pagesize = PAGE_NUMS)
    {
        $currentQuery = $this->_objModel;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('user_info.username'  , 'like', $keywords)
                    ->orwhere('user_expert.name', 'like', $keywords)
                    ->orwhere('user_expert.mobile', 'like', $keywords)
                    ->orwhere('user_expert.position', 'like', $keywords)
                    ->orwhere('user_expert.academy', 'like', $keywords)
                    ->orwhere('user_expert.resume', 'like', $keywords)
                    ->orwhere('user_expert.project_desc', 'like', $keywords);
            });
        }
        if(isset($search['territory']) && !empty($search['territory'])) {
            $department_ids = $search['territory'];
            $currentQuery = $currentQuery->where('territory',$search['territory']);
        }
        if(isset($search['status']) && !empty($search['status'])) {
            $currentQuery = $currentQuery->where('user_info.status',$search['status']);
        }
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('user_id', 'DESC');
        }
        $currentQuery = $currentQuery->leftJoin('user_info', 'user_info.id', '=', 'user_expert.user_id');

        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }



    /**
     * 按照项目空闲时间搜索
     * @param $search
     * @param $pagesize
     */
    public function searchMeetTime($search, $orderby = array(), $pagesize = 8)
    {
        $currentQuery = $this->_objModel;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('user_info.username'  , 'like', $keywords)
                    ->orwhere('user_expert.name', 'like', $keywords)
                    ->orwhere('user_expert.mobile', 'like', $keywords)
                    ->orwhere('user_expert.position', 'like', $keywords)
                    ->orwhere('user_expert.academy', 'like', $keywords)
                    ->orwhere('user_expert.resume', 'like', $keywords)
                    ->orwhere('user_expert.project_desc', 'like', $keywords);
            });
        }
        if(isset($search['territory']) && !empty($search['territory'])) {
            $department_ids = $search['type'];
            $currentQuery = $currentQuery->where('territory',$search['territory']);
        }
        if(isset($search['status']) && !empty($search['status'])) {
            $currentQuery = $currentQuery->where('user_info.status',$search['status']);
        }
        if(isset($search['is_meet_time']) && $search['is_meet_time'] && $search['counseling_times']) {
            $meet_time = counseling_timeId($search['counseling_times']);

            $currentQuery = $currentQuery->whereRaw(" FIND_IN_SET('" . $meet_time . "', user_expert.meet_time) ");
        }

        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('gov_score', 'DESC');
        }
        $currentQuery = $currentQuery->leftJoin('user_info', 'user_info.id', '=', 'user_expert.user_id');

        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }
    
    /**
     * 添加
     * @param $data
     */
    public function create($data)
    {
        //添加基础表
        \DB::beginTransaction();
        $objUser = new User();
        $baseUser['name'] = $data['name'];
        $baseUser['avater'] = $data['avater'];
        $baseUser['email'] = $data['email'];
        $baseUser['password'] = '';
        $baseUser['mobile'] = $data['mobile'];
        $baseUser['type'] = 4;
        $baseUser = $objUser->create($baseUser);
        if(!$baseUser) {
            \DB::rollback();
            $this->setMsg("创建用户失败[" . $objUser->getMessage() . "]");
            return false;
        }

        $data['user_id'] = $baseUser->id;
        $ok = $this->_objModel->create($data);
        if(!$ok) {
             \DB::rollback();
             $this->setMsg("创建用户失败[002]");
             return false;
        }
        \DB::commit();
        return $baseUser;
    }
    
    /**
     * 更新
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $obj = $this->_objModel->find($id);
        if (!$obj) {
            return false;
        }
        \DB::beginTransaction();
        $objUser = new User();
        $baseUser = [];
        if (isset($data['name']) && $data['name']) {
            $baseUser['name'] = $data['name'];
        }
        if (isset($data['avater']) && $data['avater']) {
            $baseUser['avater'] = $data['avater'];
        }
        if (isset($data['email']) && $data['email']) {
            $baseUser['email'] = $data['email'];
        }
        if(isset($data['password']) && $data['password']){
            $baseUser['password'] = $data['project_name'];;
        }
        if(isset($data['status'])) {
            $baseUser['status'] = $data['status'];
        }
        if(isset($data['visit_video'])) {
            $baseUser['visit_video'] = $data['visit_video'];
        }
        if ($baseUser){
            $ok = $objUser->update($id, $baseUser);

            if (!$ok) {
                \DB::rollback();
                $this->setMsg("更新账号信息失败[" . $objUser->getMessage() . "]");
                return false;
            }
        }
        $ok = $obj->update($data);

        if(!$ok) {
            \DB::rollback();
            $this->setMsg("没有进行任何更新[" . $objUser->getMessage() . "]");
            return false;
        }
        \DB::commit();
        return $ok;
    }
    
    
    /**
     * 获取一行数据
     * @param $where
     * @return
     */
    public function find($id)
    {
        $ok = $this->_objModel->get();
        return $this->_objModel->find($id);
    }
    
   
    /**
     * 查询多条数据
     */
    public function get($pagesize = PAGE_NUMS) {
        return $this->_objModel->take($pagesize)->orderBy('id', 'DESC')->get();
    }
    
    /**
     * 查询多条数据并分页
     */
    public function getPage($pagesize = PAGE_NUMS) {
        return $this->_objModel->orderBy('id', 'DESC')->paginate($pagesize);
    }

    /**
        更新专家的平均 评分
    */

    public function updateGovScore($user_id) {

    }
    
    
}
