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
use App\Models\UserGovModel;

class UserGov extends BaseProcess
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
        if( !$this->_objModel) $this->_objModel = new UserGovModel();
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
                $query->where('project_name'  , 'like', $keywords)
                ->orwhere('linkman_tel', 'like', $keywords)
                ->orwhere('department', 'like', $keywords)
                ->orwhere('linkman', 'like', $keywords)
                ->orwhere('linkman_tel', 'like', $keywords)
                ->orwhere('linkman_mobile', 'like', $keywords)
                ->orwhere('linkman_email', 'like', $keywords);
            });
        }
        
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('user_id', 'DESC');
        }
        $currentQuery = $currentQuery->leftJoin('user_info', 'user_info.id', '=', 'user_gov.user_id');

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
        $baseUser['name'] = $data['project_name'];
        $baseUser['avater'] = '';
        $baseUser['email'] = "";
        $baseUser['username'] = $data['username'];
        $baseUser['password'] = $data['password'];
        $baseUser['mobile'] = '';
        $baseUser['type'] = 3;
        $baseUser = $objUser->create($baseUser);
        if(!$baseUser) {
            \DB::rollback();
            $this->setMsg("创建用户失败[" . $objUser->getMessage() . "]");
            return false;
        }
        
        $this->_objModel->user_id = $baseUser->id;
        $this->_objModel->project_name = $data['project_name'];
        $this->_objModel->department = $data['department'];
        $this->_objModel->linkman_tel = $data['linkman_tel'];
        $this->_objModel->linkman = $data['linkman'];
        $this->_objModel->linkman_mobile = $data['linkman_mobile'];
        $this->_objModel->linkman_email = $data['linkman_email'];
        $this->_objModel->approve_pic = $data['approve_pic'];
        $ok = $this->_objModel->save();
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
        if(!$obj) {
            return false;
        }
        \DB::beginTransaction();
        $objUser = new User();
        $baseUser['name'] = $data['project_name'];
        if(isset($data['password']) && $data['password']){
            $baseUser['password'] = $data['password'];;
        }
        if(isset($data['status'])) {
            $baseUser['status'] = $data['status'];
        }
        if(isset($data['visit_video'])) {
            $baseUser['visit_video'] = $data['visit_video'];
        }

        $ok = $objUser->update($id,$baseUser);
        if(!$ok) {
            \DB::rollback();
            $this->setMsg("更新账号信息失败[" . $objUser->getMessage() . "]");
            return false;
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
    
    
}
