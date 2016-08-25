<?php
/**
 *  菜单管理
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
namespace App\Services\User;
use App\Services\Base\BaseProcess;
use App\Models\AdminMenusModel;
use App\Services\Base\Tree;

class Menus extends BaseProcess {
    
    /**
     * 模型
     */
    private $objModel;
    
    /**
     * 初始化
     */
    public function __construct()
    {
        if( ! $this->objModel) $this->objModel = new AdminMenusModel();
    }
    
    public function model() {
        $this->setSucessCode();
        return $this->objModel;
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

    /**
     * 删除
     * @param unknown $id
     */
    public function destroy($id)
    {
        return $this->objModel->destroy($id);
    }
    
    /**
     * 获取当前菜单层级
     * @param $pid
     * @return level
     */
    public function getLevel($id)
    {
        $tree = new Tree();
        $MenusArr = $this->objModel->orderBy('sort', 'DESC')->get()->toArray();
        $tree -> init($MenusArr);
        $allParents = $tree->getAllParents($id);
        return count($allParents) + 1;
    }
    
    /**
     * 获取菜单树状结构
     */
    public function getMenusTree($search = array()){

        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
            $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('name'  , 'like', $keywords)
                ->orwhere('module', 'like', $keywords)
                ->orwhere('contrl', 'like', $keywords)
                ->orwhere('action', 'like', $keywords);
            });
        }
        
        $MenusArr = $currentQuery->orderBy('sort', 'DESC')->get()->toArray();
        $tree = new Tree();
        $tree -> icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree -> nbsp = '&nbsp;&nbsp;&nbsp;';
        $tree -> init($MenusArr);
        return $tree -> getTree();
    }
    
    /**
     * 搜索
     * @param $search
     * @param $pagesize
     */
    public function search($search,$orderby=array('sort'=>'desc'),$pagesize = PAGE_NUMS)
    {
        $currentQuery = $this->objModel;
        if(isset($search['keyword']) && !empty($search['keyword'])) {
            $keywords = '%' . $search['keyword'] . '%';
             $currentQuery = $currentQuery->where(function ($query) use ($keywords) {
                $query->where('name'  , 'like', $keywords)
                ->orwhere('module', 'like', $keywords)
                ->orwhere('contrl', 'like', $keywords);
            });
        }
        if(isset($search['min_level']) && !empty($search['min_level'])) {
            $currentQuery = $currentQuery->where('level','<=',$search['min_level']);
        }
        if(isset($search['display']) && !empty($search['display'])) {
            $currentQuery = $currentQuery->where('display',$search['display']);
        }
        if($orderby) {
            foreach ($orderby as $key=>$sort) {
                $currentQuery = $currentQuery->orderBy($key,$sort);
            }
        }
        $currentQuery = $currentQuery->paginate($pagesize);
        return $currentQuery;
    }
    
    
}
