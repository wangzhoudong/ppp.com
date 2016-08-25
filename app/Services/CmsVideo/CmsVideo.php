<?php
namespace App\Services\CmsVideo;

use App\Services\Base\BaseProcess;
use App\Models\CmsVideoModel;

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
class CmsVideo extends BaseProcess {
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
        if( ! $this->objModel) $this->objModel = new CmsVideoModel();
    }
    
    public function search(array $search,array $orderby=array('created_at'=>'desc'),$pagesize=PAGE_NUMS)
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
        if(isset($search['status']) && !empty($search['status'])) {
            $currentQuery = $currentQuery->where('status',$search['status']);
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
        if(isset($search['status']) && !empty($search['status'])) {
            $currentQuery = $currentQuery->where('status',$search['status']);
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
        return $this->objModel->find($id);
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
     * 添加
     * @param unknown $data
     */
    public function create($data)
    {
        // 判断page是否唯一
        if($this->objModel->where('title', '=', $data['title'])->count()){
            $this->setMsg("已经存在【{$data['title']}】视频！");
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
            $this->setMsg("未找到【{$id}】信息！");
            return false;
        }
        
        // 判断page是否唯一
        if($this->objModel->where('title', '=', $data['title'])->count() && $obj->title != $data['title']){
            $this->setMsg("已经存在【{$data['title']}】视频！");
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
