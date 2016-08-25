<?php
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月12日
 *
 */
namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use App\Services\User\User;
use App\Services\User\UserExpert;
use Request;

class ExpertController extends Controller
{
    private $_service;
    private $_userService;

    /**
     * 初始化Service
     */
    public function __construct()
    {
        parent::__construct();
        if(!$this->_service) $this->_service = new UserExpert();
        if(!$this->_userService) $this->_userService = new User();
    }
    
    /**
     * 列表
     */
    function index()
    {
        $request = Request::all();
        $search['keyword'] = Request::input('keyword');
        $orderby = array();
        if(isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $orderby[$request['sort_field']] = $request['sort_field_by'];
        }
        $list = $this->_service->search($search, $orderby);
        return view('admin.user.expert.index', compact('list'));
    }
    
    /**
     * 更新
     */
    public function update()
    {
        if(Request::method() == 'POST'){
            $data = Request::input('data');
            if($this->_service->update(Request::input('id'), $data)){
                $this->showMessage('操作成功', urldecode(Request::input('_referer')));
            }else{
                $this->showWarning('操作失败', urldecode(Request::input('_referer')));
            }
        }
        $data = $this->_userService->find(request('id'));
        return view('admin.user.expert.edit', compact('data'));
    }

}