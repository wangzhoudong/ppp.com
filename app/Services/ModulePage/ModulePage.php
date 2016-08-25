<?php
/**
 *  友情链接
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
namespace App\Services\ModulePage;

use App\Services\Base\BaseProcess;
use App\Models\ModulePageParamsModel;

class ModulePage extends BaseProcess {
    /**
     * 模型
     *
     * @var object
     * 
     */
    private $objModel;
    
    private $groupModel;
    
    private $userInfo;
    
    
    /**
     * 初始化
     *
     * @access public
     * 
     */
    public function __construct()
    {
        if( ! $this->objModel) $this->objModel = new ModulePageParamsModel();
    }
    
    public function model() {
        $this->setSucessCode();
        return $this->objModel;
    }
    public function search(array $search,array $orderby=array('sort','desc'),$pagesize=PAGE_NUMS) 
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('page'  , 'like', $keywords)
                 ->orwhere('name', 'like', $keywords);
            });
        }
        if(isset($search['link_page']) && ! empty($search['link_page'])) {
            $currentQuery = $currentQuery->where('page',$search['link_page']);
        }
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
                $currentQuery = $currentQuery -> orderBy($field, $value);
            }
        }
        
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }
    
    public function getAll($where,$orderby) {
        //条件
        $currentQuery = $this->objModel;
        if($where && is_array($where)){
            foreach ($where AS $field => $value){
               $currentQuery=   $currentQuery -> where($field, $value);
            }
        }
        
        //排序
        if($orderby && is_array($orderby)){
            foreach ($orderby AS $field => $value){
               $currentQuery =  $currentQuery -> orderBy($field, $value);
            }
        }
        return $currentQuery->get();
    }
    
    public function getPage() {
        $query = $this->objModel->select("page")->groupBy("page")->get();
        return $query;
    }
    
    public function getDataByPage($page) {
        return $this->objModel->where('page', '=', trim($page))->get();
    }
    
    public function getByKey($page,$key) {
        return $this->objModel->where('page', '=', trim($page))->where('key', '=', trim($key))->first();
    }

    public function find($id) {
        return $this->objModel->find($id);
    }
    /**
     * 添加
     * @param unknown $data
     */
    public function create($data)
    {
        return $this->objModel->create($data);
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
            return false;
        }
        $ok = $obj->update($data);
        return $ok;
    }
    
    public function updateStatus($id,$status) {
        $data = $this->objModel->find($id);
        $data->status = $status;
        return $data->save();
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
