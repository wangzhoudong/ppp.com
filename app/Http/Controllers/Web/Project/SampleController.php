<?php

namespace App\Http\Controllers\Web\Project;

use App\Models\ProjectExpertModel;
use App\Models\UserInfoModel;
use App\Services\Project\Expert;
use App\Services\Project\Project;
use App\Services\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;
use Symfony\Component\Console\Question\Question;
use Validator;

class SampleController extends Controller
{
    
    private $_service;
    private $_UserService;
    private $_userInfo;
    private $_project_id;
    private $_project;
    
    function __construct()
    {

        parent::__construct();
        if ( !$this->_service ) $this->_service = new Project();
        $this->_project_id = request('project_id');
        if(!$this->_project_id ) {
            abort(404);
        }
        $this->_project = $this->_service->find($this->_project_id);
        if(!$this->_project ) {
            abort(404);
        }
        if(!$this->_project['type']==1) {
            return redirect('/login/index')->with('message','请登录');
        }
        view()->share('project', $this->_project);

    }


    
    /**
     * 首页
     */
    public function index()
    {
        if(isset($this->_user['notice_project_detail']) && $this->_user['notice_project_detail']) {
            $ok = (new UserInfoModel())->where('id',$this->_user['id'])->update(['notice_project_detail'=>0]);
        }
        $beforeYear =beforeYear(5);
        $afterYear = afterYear(30);
        return view('web.project.sample.index', compact('beforeYear','afterYear'));
    }

    public function expert(){
        if(isset($this->_user['notice_project_export']) && $this->_user['notice_project_export']) {
            $ok = (new UserInfoModel())->where('id',$this->_user['id'])->update(['notice_project_export'=>0]);
        }
        $obj = new Expert();
        $data = $obj->getByProject($this->_project_id);
        return view('web.project.sample.expert', compact('data'));
    }

    public function meeting($project_id) {

    }

    public function question(){
        if(isset($this->_user['notice_project_question']) && $this->_user['notice_project_question']) {
            $ok = (new UserInfoModel())->where('id',$this->_user['id'])->update(['notice_project_question'=>0]);
        }
        $obj = new \App\Services\Project\Question();
        $question = $obj->getByProject($this->_project_id);

        return view('web.project.sample.question', compact('question'));
    }

    /**权重**/
    public function weight(){

         return  $this->govWeight($this->_project_id);
    }

    public function govWeight() {
        $obj = new Expert();
        $data = $obj->getByProject($this->_project_id);
        return view('web.project.sample.govWeight', compact('data'));
    }
    public function expertWeight() {
        $obj = new Expert();
        $data = $obj->getByProject($this->_project_id,$this->_user['id']);
        return view('web.project.sample.expertWeight', compact('data'));

    }

    public function score(){
        $obj = new Expert();
        $data = $obj->getByProject($this->_project_id);
        return view('web.project.sample.govScore', compact('data'));
    }

    public function govScore() {
        $obj = new Expert();
        $data = $obj->getByProject($this->_project_id);
        return view('web.project.sample.govScore', compact('data'));
    }
    public function expertScore() {
        $obj = new Expert();
        $data = $obj->getByProject($this->_project_id,$this->_user['id']);
        return view('web.project.sample.expertScore', compact('data'));

    }

    public function risk(){
        return view('web.project.sample.risk', compact('data'));
    }

}
