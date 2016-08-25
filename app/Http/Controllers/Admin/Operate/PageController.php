<?php
/**
 *  文章
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月15日
 *
 */
namespace App\Http\Controllers\Admin\Operate;
use App\Http\Controllers\Admin\Controller;
use Request;
use App\Services\ModulePage\ModulePage;
class PageController extends Controller
{
    private $_service;
    
    public function __construct() {
        parent::__construct();
        if(!$this->_service) $this->_service = new ModulePage();
    }

    public function manage() {
        $jump_url = 'http://' . config('sys.sys_www_domain') . '/?front_key=' . session()->getId();
        return view('admin.operate.page.manage', compact('jump_url'));
    }

    public function index() {
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');
        $search['link_page'] = Request::input('link_page');
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $list = $this->_service->search($search,$orderby);
        $linkPage = $this->_service->getPage();
        return view('admin.operate.page.index',compact('list','linkPage'));
    }
    
    /**
     * 添加
     */
    public function create()
    {
        if(Request::method() == 'POST') {
            return $this->_createSave();
        }
        return view('admin.operate.page.edit');
    }
    
    private function _createSave(){
        $data = (array) Request::input('data');
        $data['page'] = formatUri($data['page']);
        $id = $this->_service->create($data);
        if($id) {
            $url[] = array('url'=>U( 'Operate/Page/index'),'title'=>'返回列表');
            $url[] = array('url'=>U( 'Operate/Page/create'),'title'=>'继续添加');
            $this->showMessage('添加成功',$url);
        }else{
            $url[] = array('url'=>U( 'Operate/Page/index'),'title'=>'返回列表');
            $this->showWarning('添加失败',$url);
        }
    }
    
    /**
     * 修改
     */
    public function update() {
        if(Request::input('page_key')){
            return $this->_frontEdit();
        }else{
            return $this->_behindEdit();
        }
    }

    public function logout() {
        session()->getHandler()->destroy(session()->get(LOGIN_MARK_SESSION_KEY.'.front_session_id'));
        $this->showMessage('操作成功');
    }

    /**
     * 前端编辑
     */
    private function _frontEdit() {
        $page_key = request('page_key');
        $data = $this->_service->getByKey(Request::get('uri'),$page_key);

        if(request()->method() == 'POST') {
            //统一处理URI后斜线问题
            $info = request('data');
            $info['page'] = formatUri($info['page']);
            if($data){
                $res = $this->_service->update(request('id'), $info);
            }else{
                $res = $this->_service->create($info);
            }

            if($res) {
                $filePath = storage_path() . "/framework/cache/";
                \File::cleanDirectory($filePath);
                $this->showMessage('编辑成功');
            }else{
                $this->showWarning('编辑失败');
            }
        }

        if(!$data){
            $data['key'] = $page_key;
            $data['page'] = urldecode(Request::get('uri'));
        }

        return view('admin.operate.page.frontedit',compact('data'));
    }

    /**
     * 后端编辑
     */
    private function _behindEdit() {
        if(Request::method() == 'POST') {
            return $this->_updateSave();
        }
        $data = $this->_service->find(Request::get('id'));
        return view('admin.operate.page.edit',compact('data'));
    }

    private function _updateSave() {
        $data = (array) Request::input('data');
        $data['page'] = formatUri($data['page']);

        $ok = $this->_service->update(Request::get('id'), $data);
        if($ok) {
            $url[] = array('url'=>U( 'Operate/Page/index'),'title'=>'返回列表');
            $this->showMessage('操作成功',urldecode(Request::input('_referer')));
        }else{
            $url[] = array('url'=>U( 'Operate/Page/index'),'title'=>'返回列表');
            $this->showWarning('操作失败',$url);
        }
    }

    public function status() {
        $ok = $this->_service->updateStatus(Request::get('id'),Request::get('status'));
        if($ok) {
             $this->showMessage('操作成功');
        }else{
            $this->showWarning('操作失败');
        }
    }
    
    /**
     * 删除
     */
    public function destroy() {
        $bool = $this->_service->destroy(Request::input('id'));
        if($bool) {
              $this->showMessage('操作成功');
        }else{
            $this->showWarning("操作失败");
        }
    }

}