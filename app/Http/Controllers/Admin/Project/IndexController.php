<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Admin\Controller;
use App\Services\Project\Project;
use Request;

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
class IndexController extends Controller
{
    private $_service;
    
    public function __construct() {
        if(!$this->_service) $this->_service = new Project();
    }
    
    /**
     * 待审核
     */
    public function auditList() {
        $search['status'] = 2;
        return $this->_list($search);
    }

    /**
     * 用户未提交
     */
    public function waitList() {
        $search['status'] = 1;
        return $this->_list($search);
    }
    //已发布
    public function index() {
        return $this->_list([]);
    }

    public function doneAuditList() {
        $search['status'] = 10;
        return $this->_list($search);
    }
    public function contractList() {
        $search['status'] = 20;
        return $this->_list($search);
    }

    public function fistPaytList() {
        $search['status'] = 30;
        return $this->_list($search);
    }

    public function prepareExpertstList() {
        $search['status'] = 40;
        return $this->_list($search);
    }

    public function doneExpertstList() {
        $search['status'] = 50;
        return $this->_list($search);
    }

    public function reportList() {
        $search['status'] = 60;
        return $this->_list($search);
    }

    public function donePayList() {
        $search['status'] = 70;
        return $this->_list($search);
    }


    /**
     * 用户未提交
     */
    public function sampleList() {
        $search['type'] = 2;
        return $this->_list($search);
    }


    private function _list($search) {
        $aStatuBotton = [
            1=>array(['status'=>2,'name'=>'设置为待审核']),
            2=>array(['status'=>10,'name'=>'已审核']),
            10=>array(['status'=>2,'name'=>'待审核'],['status'=>20,'name'=>'合同签订']),
            20=>array(['status'=>10,'name'=>'已审核'],['status'=>30,'name'=>'首款支付']),
            30=>array(['status'=>20,'name'=>'合同签订'],['status'=>40,'name'=>'准备专家会']),
            40=>array(['status'=>30,'name'=>'首款支付'],['status'=>50,'name'=>'专家会完成']),
            50=>array(['status'=>40,'name'=>'准备专家会'],['status'=>60,'name'=>'出具报告']),
            60=>array(['status'=>50,'name'=>'专家会完成'],['status'=>70,'name'=>'已付尾款']),
            70=>array(['status'=>60,'name'=>'出具报告']),
        ];

        $request = Request::all();
        $search['keyword'] = Request::input('keyword');

        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }

        $list = $this->_service->search($search,$orderby);
        return view('admin.project.index.list',compact('list','aStatuBotton'));
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
        return view('admin.cms.video.edit');
    }
    
    private function _createSave(){
        $data = (array) Request::input('data');
        
        $id = $this->_service->create($data);
        
        $url   = array();
        $url[] = array('url'=>U( 'Cms/Video/index'),'title'=>'返回列表');
        $url[] = array('url'=>U( 'Cms/Video/create'),'title'=>'继续添加');
        
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
        return view('admin.cms.video.edit',compact('data'));
    }
    
    private function _updateSave() {
        $data = (array) Request::input('data');
        
        $ok = $this->_service->update(Request::get('id'),$data);
        
        $url   = array();
        $url[] = array('url'=>U( 'Cms/Video/index'),'title'=>'返回列表');
        
        $this->showMessage(($ok !== false?'操作成功':$this->_service->getMessage()),$url);
    }


    public function status() {
        $ok = $this->_service->updateStatus(Request::get('id'),Request::get('status'));
        if($ok) {
            return redirect()->back()-> with('message','操作成功');
//            $this->showMessage('操作成功');
        }else{
            return redirect()->back()-> with('message','操作失败');
        }
    }


    public function type() {
        $ok = $this->_service->updateType(Request::get('id'),Request::get('type'));
        if($ok) {
            return redirect()->back()-> with('message','操作成功');
//            $this->showMessage('操作成功');
        }else{
            return redirect()->back()-> with('message','操作失败');
        }
    }

    /**
     * 删除
     */
    public function destroy() {
        $bool = $this->_service->destroy(Request::input('id'));
        $this->showMessage($bool !== false?'操作成功':'操作失败');
    }

    public function upimg() {
        $projectId = request('project_id');
        $img = request('url');
        $ok = $this->_service->update($projectId,['image'=>$img]);
        if($ok) {
            exit(json_encode(['status'=>SUCESS_CODE]));
        }else{
            exit(json_encode(['status'=>FAILURE_CODE,'msg',$this->_service->getMessage()]));
        }
    }


    public function view() {

        return view('admin.project.index.view',compact('data'));

    }

}