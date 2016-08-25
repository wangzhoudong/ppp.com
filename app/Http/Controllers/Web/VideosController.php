<?php

namespace App\Http\Controllers\Web;

use App\Services\CmsVideo\CmsVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;

class VideosController extends Controller
{
    
    private $_service;
    
    function __construct()
    {
        parent::__construct();
        if(!$this->_service) $this->_service = new CmsVideo();
    }
    
    /**
     * 首页
     */
    public function index()
    {
        $list = $this->_service->search(['status'=>1],['created_at'=>'desc'],24);
        return view('web.videos.index', compact('list'));
    }
}
