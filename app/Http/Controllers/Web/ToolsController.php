<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;

class ToolsController extends Controller
{

    private $_service;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function uploadImg()
    {
        $fooder = request('fooder');
        $token = request('token');
        $time = request('time');
        if(SYSTEM_TIME-$time>3600) {
            exit('请求过期，请重新发起请求');
        }
        if($token != md5($fooder. LOGIN_MARK_SESSION_KEY . $time)) {
           exit('非法访问');

        }
        return view('web.tools.uploadImg');
    }

}
