<?php

namespace App\Http\Controllers\Web;

use App\Services\CmsVideo\CmsVideo;
use App\Services\Project\Expert;
use App\Services\Project\Project;
use App\Services\User\UserExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;

class IndexController extends Controller
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
        //项目
        $objProject = new Project();
        $projectInfo = $objProject->search(['type'=>2],[],6);

        //专家
        $objUserExpert = new UserExpert();
        $userExpert = $objUserExpert->search(['status'=>1],['hot'=>'desc'],8);

        $objVideo = new CmsVideo();
        $videoInfo = $objVideo->getAll(['status'=>1],['hot'=>'desc'],4);
        return view('web.index', compact('projectInfo','userExpert','videoInfo'));
    }
    
}
