<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Admin\Controller;
use Request;
use App\Services\CmsMeta\CmsMeta;

/**
 * 
 *--------------------------------------------------------------------------
 * META信息管理
 *--------------------------------------------------------------------------
 *
 * @author wangzhoudong
 * @date 2015年12月29日 下午4:21:16
 * @version V1.0
 *
 */
class MetaController extends Controller
{
    private $_service;
    
    public function __construct() {
        if(!$this->_service) $this->_service = new CmsMeta();
    }
    
    /**
     * 列表
     */
    public function index() {
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');
        
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        
        $list = $this->_service->search($search,$orderby);
        
        return view('admin.cms.meta.index',compact('list'));
    }
    
    /**
     * 添加
     * 
     */
    public function create()
    {
        if(Request::method() == 'POST') {
            $this->_createSave();
        }
        return view('admin.cms.meta.edit');
    }
    
    private function _createSave(){
        $data = (array) Request::input('data');
        
        $id = $this->_service->create($data);
        
        $url   = array();
        $url[] = array('url'=>U( 'Cms/Meta/index'),'title'=>'返回列表');
        $url[] = array('url'=>U( 'Cms/Meta/create'),'title'=>'继续添加');
        
        $this->showMessage(($id !== false?'添加成功':$this->_service->getMessage()),$url);
    }
    
    /**
     * 
     * 修改
     * 
     */
    public function update() {
        if(Request::method() == 'POST') {
            $this->_updateSave();
        }
        
        $data = $this->_service->find(Request::get('id'));
        return view('admin.cms.meta.edit',compact('data'));
    }
    
    private function _updateSave() {
        $data = (array) Request::input('data');
        
        $ok = $this->_service->update(Request::get('id'),$data);
        
        $url   = array();
        $url[] = array('url'=>U( 'Cms/Meta/index'),'title'=>'返回列表');
        
        $this->showMessage(($ok !== false?'操作成功':$this->_service->getMessage()),$url);
    }
    
    /**
     * 删除
     */
    public function destroy() {
        $bool = $this->_service->destroy(Request::input('id'));
        $this->showMessage($bool !== false?'操作成功':'操作失败');
    }
}