<?php

namespace App\Http\Controllers\Web;

use App\Services\User\User;
use App\Services\User\UserExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;

class ExpertController extends Controller
{
    
    private $_service;
    
    function __construct()
    {
        parent::__construct();
        if ( !$this->_service ) $this->_service = new UserExpert();

    }
    
    /**
     * 首页
     */
    public function index()
    {
        $search['territory'] = request('territory');
        $search['status'] = 1;
        $data = $this->_service->search($search);

        return view('web.expert.index', compact('data'));
    }

    public function detail($user_id) {
        $item = $this->_service->find($user_id);
        return view('web.expert.detail', compact('item'));

    }
    
}
