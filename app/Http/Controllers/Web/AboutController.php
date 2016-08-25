<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;

class AboutController extends Controller
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
        return view('web.about.content', compact('data'));
    }

    public function protocol() {

        return view('web.about.content', compact('data'));
    }

    public function pay() {

        return view('web.about.content', compact('data'));
    }

    public function user() {

        return view('web.about.content', compact('data'));
    }
}
