<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Admin\Controller;
use App\Services\Project\Expert;
use App\Services\Project\Project;
use App\Services\Project\Question;
use App\Services\User\UserExpert;
use Request;
use Validator;

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
class InfoController extends Controller
{
    private $_service;
    
    public function __construct() {
        parent::__construct();
        if(!$this->_service) $this->_service = new Project();
    }
    
    public function update() {
        $data = [];
        $project_id = request()->get('project_id');
        $data = $this->_service->find($project_id);

        if(request()->method() == 'POST') {
            $this->_updateSave();
        }

        $beforeYear =beforeYear(5);
        $afterYear = afterYear(30);

        return view('admin.project.info.edit',compact('data','beforeYear','afterYear'));

    }

    public function _updateSave() {
        $_request = Request::all();
        $request = request();

        $data['name'] = $request->get('itemName');
        $data['place_area_id'] = $request->get('place_area_id');
        $data['place_province_id'] = $request->get('place_province_id');
        $data['place_city_id'] = $request->get('place_city_id');
        $data['recent_5_year'] = $request->get('recent_5_year');
        $data['financial_situation'] = $request->get('financial_situation');
        $data['builder_company'] = $request->get('builder_company');
        $data['item_project'] = $request->get('item_project');
        $data['property'] = $request->get('itemProperty');
        $data['operation_pattern'] = $request->get('operation_pattern');
        $data['asset_ownership'] = $request->get('asset_ownership');
        $data['project_nature'] = $request->get('project_nature');
        $data['financing_proportion_zf'] = $request->get('financing_proportion_zf');
        $data['financing_proportion_sh'] = $request->get('financing_proportion_sh');
        $data['financing_proportion_xm'] = $request->get('financing_proportion_xm');
        $data['financing_proportion_xm_count'] = $request->get('financing_proportion_xm_count');
        $data['project_financial'] = $request->get('project_financial');
        $data['supporting_plan'] = $request->get('supporting_plan');
        $data['current_progress'] = $request->get('current_progress');
        $data['land_acquisition'] = $request->get('land_acquisition');
        $data['operating_taxes'] = $request->get('operating_taxes');
        $data['social_capital'] = $request->get('social_capital');
        $data['financing_loans_desc'] = $request->get('financing_loans_desc');
        $data['pre_scheme_file'] = $request->get('pre_scheme_file');
        $upload_file = $request->get('other_info_file');

        if($upload_file){
            $aImg = [];
            foreach($upload_file['url'] as $key=>$img) {
                $aImg[] = ['url'=>$img,'alt'=>$upload_file['alt'][$key]];
            }
            $data['other_info_file'] = json_encode($aImg);
        }
        $project_id = $request->get('project_id');
        $projectInfo = $this->_service->find($project_id);
        if($projectInfo) {
            $ok = $this->_service->update($projectInfo['id'],$data);
            if($ok) {
                return exit(json_encode(['status'=>SUCESS_CODE,'data'=>$projectInfo]));
            }else{
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
            }
        }else{
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
        }

    }

    /**
     * 专家
     */
    public function expert() {
        $project_id = request()->get('project_id');
        $data = $this->_service->find($project_id);
        $obj = new Expert();
        $expert = $obj->getByProject($project_id);
        $searchObj = new UserExpert();
        $search['status'] = 1;
        $search['keyword'] = request()->get('keyword');
        $search['is_meet_time'] = request()->get('is_meet_time');
        $search['counseling_times'] = $data['counseling_times'];
        $orderby = array();
        if(request()->get('sort_field')) {
            $orderby[request()->get('sort_field')] = request()->get('sort_field_by');
        }
        $searchExpert = $searchObj->searchMeetTime($search,$orderby);
        return view('admin.project.info.expert',compact('data','expert','afterYear','searchExpert'));

    }

    public function addExpert() {
        $project_id = request()->get('project_id');
        $user_id = request()->get('user_id');
        $territory = request()->get('territory');
        $obj = new Expert();
        $ok = $obj->create($project_id,$user_id,$territory);
        if($ok) {
            $this->showMessage('操作成功');
        }else{
            $this->showWarning($obj->getMessage());
        }

    }

    public function delExpert() {
        $id = request()->get('id');
        $obj = new Expert();
        $ok = $obj->destroy($id);
        if($ok) {
            return redirect()->back()->with('message','操作成功');

            $this->showMessage('操作成功');
        }else{
            return redirect()->back()->with('message','操作失败');
            $this->showWarning('操作失败');
        }
    }

    /**
     * 专家
     */
    public function question() {
        $project_id = request()->get('project_id');
        $obj = new Question();
        if(request()->method() == 'POST') {
            $addData['project_id'] = request('project_id');
            $addData['user_id'] = $this->_user['id'];
            $addData['title'] = request('title');
            $ok = $obj->create($addData);
            if($ok) {
                $this->showMessage('创建成功');
            }else{
                $this->showWarning('创建失败');
            }
        }
        $data = $this->_service->find($project_id);
        $question = $obj->getByProject($project_id);
        return view('admin.project.info.question',compact('data','question','afterYear'));

    }

    /**
     * 专家会
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function meeting() {
        $project_id = request()->get('project_id');
        if(request()->method() == 'POST') {
            if(!request()->get('counseling_times')) {
                $this->showWarning('请选择时间');
            }

            $editData['counseling_times'] = strtotime(request()->get('counseling_times'));

            $ok = $this->_service->update($project_id,$editData);
            if($ok) {
                $this->showMessage('创建成功');
            }else{
                $this->showMessage('创建失败');
            }
        }
        $data = $this->_service->find($project_id);

        return view('admin.project.info.meeting',compact('data','userExpert','afterYear'));
    }

    /**
     * 专家
     */
    public function weight() {
        $project_id = request()->get('project_id');
        if(request()->method() == 'POST') {
            $updateData = request('data');
            $count = 0;
            foreach($updateData as $val) {
                $count = $count+$val;
            }
            if($count!=100) {
                $this->showWarning('指标合计必须等于100');
            }

            $ok = $this->_service->update($project_id,$updateData);
            if($ok) {
                $this->showMessage('操作成功');
            }else{
                $this->showWarning('操作失败');
            }
        }
        $obj = new Expert();
        $userExpert = $obj->getByProject($project_id);
        $data = $this->_service->find($project_id);
        return view('admin.project.info.weight',compact('data','userExpert','afterYear'));

    }

    /**
     * 专家
     */
    public function score() {
        $project_id = request()->get('project_id');

        $obj = new Expert();
        $userExpert = $obj->getByProject($project_id);
        $data = $this->_service->find($project_id);
        return view('admin.project.info.score',compact('data','userExpert','afterYear'));

    }


    

}