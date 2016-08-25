<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;

class FlowController extends Controller
{
    
    private $_service;
    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 首页
     */
    public function index()
    {
        return view('web.flow.index', compact('data'));
    }
    
}
