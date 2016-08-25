<?php

/**
 *  部门
 *  @author wangzhoudong
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
 
namespace App\Services\User;

use App\Services\Base\BaseProcess;
use App\Models\AdminDepartmentModel;
use Illuminate\Queue\Console\RetryCommand;
use App\Services\Base\Tree;

class Department extends BaseProcess
{
    /**
     * 模型
     */
    private $_model;
    
    /**
     * Services
     */
    private $_servicesRole;
    
    /**
     * 初始化
     */
    public function __construct()
    {
        if( !$this->_model ) $this->_model = new AdminDepartmentModel();
        if( !$this->_servicesRole ) $this->_servicesRole = new Role();
    }
    
    public function model()
    {
        $this->setSucessCode();
        return $this->_model;
    }
    
    /**
     * 搜索
     * @param $search
     * @param $pagesize
     */
    public function search($search, $orderby, $pagesize = PAGE_NUMS)
    {
        $currentQuery = $this->_model;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('name'  , 'like', $keywords)
                ->orwhere('remark', 'like', $keywords);
            });
        }
        
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }else{
            $currentQuery = $currentQuery->orderBy('id', 'DESC');
        }
        
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }

    /**
     * 添加
     * @param $data
     */
    public function create($data)
    {
        return $this->_model->create($data);
    }
    
    /**
     * 更新
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $obj = $this->_model->find($id);
        if(!$obj) {
            return false;
        }
        $ok = $obj->update($data);
        return $ok;
    }
    
    /**
     * 更新状态
     * @param $id
     * @param $status
     */
    public function updateStatus($id, $status)
    {
        $data = $this->_model->find($id);
        $data->status = $status;
        return $data->save();
    }
    
    /**
     * 删除
     * @param $id
     */
    public function destroy($id)
    {
        $adminRole = $this->_model->find($id);
        $count = $this->_servicesRole->getCountByDepartmentId($adminRole->id);
        if($count){
            $this->setMsg("该部门在使用！");
            return false;
        }
        return $this->_model->destroy($id);
    }
    
    /**
     * 获取一行数据
     * @param $where
     * @return
     */
    public function find($id)
    {
        return $this->_model->find($id);
    }
    
    /**
     * 根据状态获取部门列表
     * @param $status
     * @return
     */
    public function getDepartmentList($status = 1)
    {
        return $this->_model->where('status', $status)->orderBy('id', 'DESC')->get();
    }
    
    /**
     * 通过sdk获取部门列表
     * @param $department_id
     * @return
     */
    public function getDepartmentListForSDK($department_id = 0)
    {
        $key = 'getdepartmentlistforsdk_' .  $department_id;
        $data  = \Cache::get($key);
        if(!$data){
            $data = \lwjsdk::load('ssosdk')->getDepartmentList($department_id);
            \Cache::forever($key,$data);
        }
        return $data;
    }
    
    /**
     * 根据部门ID获取树形结构
     * @param number $department_id
     */
    public function getTreeByDepartmentId($department_id = 0){
        $result = $this->getDepartmentListForSDK($department_id);
        
        if(isset($result['status']) && $result['status'] == SUCESS_CODE){
            $tree = new Tree();
            $tree -> icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
            $tree -> nbsp = '&nbsp;&nbsp;&nbsp;';
            $tree -> init(array_map(function($item){
                $item['pid'] = $item['parentId'];
                unset($item['parentId']);
                return $item;
            }, $result['data']));
            return $tree -> getTree();
        }
        
        $this->setMsg($result['msg']);
        $this->setCode($result['status']);
        return false;
    }
    
    
    /**
     * 根据部门ID获取子集本身的ID
     * @param number $department_id
     * @return multitype:array
     */
    public function getChildrenDepartmentId($department_id = 0)
    {
        $result = $this->getDepartmentListForSDK($department_id);
        $ids = array($department_id);
        if(isset($result['status']) && $result['status'] == SUCESS_CODE){
            $this->_countDepartmentId($ids, $result['data']);
            return $ids;
        }
        
        $this->setMsg($result['msg']);
        $this->setCode($result['status']);
        return false;
    }
    
    private function _countDepartmentId(&$ids, $data = array()){
        $_ids = array();
        foreach ((array)$data as $key=>$value){
            if(in_array($value['parentId'], $ids)){
                $_ids[] = $value['id'];
                unset($data[$key]);
            }else{
                continue;
            }
        }
        if($_ids && $data){
            $ids = array_merge($ids, $_ids);
            $this->_countDepartmentId($ids,$data);
        }
    }
    
    
    
    
}
