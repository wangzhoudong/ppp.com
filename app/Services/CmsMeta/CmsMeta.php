<?php
namespace App\Services\CmsMeta;

use App\Services\Base\BaseProcess;
use App\Models\CmsMetaModel;

/**
 * 
 *--------------------------------------------------------------------------
 * 
 *--------------------------------------------------------------------------
 *
 * @author wangzhoudong
 * @date 2015年12月29日 下午4:32:56
 * @version V1.0
 *
 */
class CmsMeta extends BaseProcess {
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
        if( ! $this->objModel) $this->objModel = new CmsMetaModel();
    }
    
    public function search(array $search,array $orderby=array('sort','desc'),$pagesize=PAGE_NUMS) 
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('page'  , 'like', $keywords)
                 ->orWhere('title', 'like', $keywords)
                 ->orWhere('keywords', 'like', $keywords)
                 ->orWhere('description', 'like', $keywords);
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
    public function create($data)
    {
        // 判断page是否唯一
        if($this->objModel->where('page', '=', $data['page'])->count()){
            $this->setMsg("已经存在【{$data['page']}】页面！");
            return false;
        }
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
            $this->setMsg("未找到【{$id}】META信息！");
            return false;
        }
        
        // 判断page是否唯一
        if($this->objModel->where('page', '=', $data['page'])->count() && $obj->page != $data['page']){
            $this->setMsg("已经存在【{$data['page']}】页面！");
            return false;
        }
        
        $ok = $obj->update($data);
        return $ok;
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
