<?php

namespace App\Http\Controllers\Web;

use App\Services\Project\Project;
use App\Services\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;
use Validator;

class ProjectController extends Controller
{
    
    private $_service;
    private $_UserService;

    function __construct()
    {
        parent::__construct();
        if ( !$this->_service ) $this->_service = new Project();

    }
    
    /**
     * 首页
     */
    public function index()
    {
        switch($this->_user['type']) {
            case 3:
                $data = $this->_service->getByGov($this->_user['id']);

                if(count($data)==1) {
//                    return redirect("/project/info/detail/" . $data[0]['id']);
                }
                break;
            case 4:
                $data = $this->_service->getByExpert($this->_user['id']);
                if(count($data)==1) {
//                    return redirect("/project/info/detail/" . $data[0]['id']);
                }
                break;
            default:
                exit("其他用户没有权限，敬请期待");
                break;
        }
        $beforeYear =beforeYear(5);
        $afterYear = afterYear(30);
        return view('web.project.list', compact('data','beforeYear','afterYear'));
    }



    public function addOne(Request $request) {
        $data = [];
        $project_id = $request->get('project_id');
        if($project_id) {
            $data = $this->_service->find($project_id);
        }
        if($data) {
            if($data['user_id'] !== $this->_user['id']) {
                return redirect("/")-> with('message','你无权操作此项目');
            }
            if($data['status']>1) {
             //   return redirect("/")-> with('message','项目已经提交,不能再编辑');
            }
        }
      
        if($request->method() == 'POST') {
            $this->_addOneSave($request);
        }
        if(!$data) {
//            $data['name'] = $this->_user['name'];
        }
        $beforeYear =beforeYear(5);
        $afterYear = afterYear(30);

        return view('web.project.addone', compact('data','beforeYear','afterYear'));
    }


    /**
     * 第一步
     * @param Request $request
     */
    private function _addOneSave(Request $request) {
        $rules = array(
            'itemName'          => 'required',
            'place_area_id'       => 'required',
            'builder_company' => 'required',
            'recent_5_year' => 'required',
        );
        $messages = array(
            'itemName.required'    => '项目名',
            'place_area_id.required'    => '所在地：',
            'financial_situation.required'    => '财政情况',
        );
        $_request = $request->all();
        $validator = Validator::make($_request, $rules, $messages);
        if($validator->fails()){
//            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
        }
        $data['user_id'] = $this->_user['id'];
        $data['name'] = $request->get('itemName');
        $data['place_area_id'] = $request->get('place_area_id');
        $data['place_province_id'] = $request->get('place_province_id');
        $data['place_city_id'] = $request->get('place_city_id');
        $data['recent_5_year'] = $request->get('recent_5_year');
        $data['financial_situation'] = $request->get('financial_situation');
        $data['builder_company'] = $request->get('builder_company');
        $data['item_project'] = $request->get('item_project');
        $project_id = $request->get('project_id');
        $projectInfo = [];
        if($project_id) {
            $projectInfo = $this->_service->find($project_id);
        }
        if($projectInfo) {
            $ok = $this->_service->update($projectInfo['id'],$data);
        }else{
            $ok = $this->_service->create($data);
            $projectInfo  = $ok;
        }

        if($ok) {
            return exit(json_encode(['status'=>SUCESS_CODE,'data'=>$projectInfo]));
        }else{
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
        }
    }



    public function addTwo(Request $request) {
        $project_id = $request->get('project_id');
        $data = $this->_service->find($project_id);
        if(!$data) {
            return redirect("/project/add1")-> with('message','你还没有创建项目，请先创建项目');
        }
        if($data) {
            if($data['user_id'] !== $this->_user['id']) {
                return redirect("/")-> with('message','你无权操作此项目');
            }
            if($data['status']>1) {
          //      return redirect("/project.html?project_id=" . $project_id)-> with('message','项目已经提交,不能再编辑');
            }
        }

        if($request->method() == 'POST') {
            $this->_addTwoSave($request,$data);
        }
        return view('web.project.addtwo', compact('data','beforeYear','afterYear'));
    }


    public function _addTwoSave(Request $request,$projectInfo) {
        $rules = array(
            'itemProperty' => 'required',
            'operation_pattern' => 'required',
            'asset_ownership' => 'required',
            'project_nature' => 'required',
        );
        $messages = array(
            'itemName.required'    => '请选择项目属性',
            'operation_pattern.required'    => '请选择项目运作模式',
            'asset_ownership.required'    => '请选择项目资产归属',
            'project_nature.required'    => '请选择项目性质',
        );
        $_request = $request->all();
        $validator = Validator::make($_request, $rules, $messages);
        if($validator->fails()){
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
        }
        $data['property'] = $request->get('itemProperty');
        $data['operation_pattern'] = $request->get('operation_pattern');
        $data['asset_ownership'] = $request->get('asset_ownership');
        $data['project_nature'] = $request->get('project_nature');
        $data['financing_proportion_zf'] = $request->get('financing_proportion_zf');
        $data['financing_proportion_sh'] = $request->get('financing_proportion_sh');
        $data['financing_proportion_xm'] = $request->get('financing_proportion_xm');

        $ok = $this->_service->update($projectInfo['id'],$data);
        if($ok) {
            return exit(json_encode(['status'=>SUCESS_CODE,'data'=>$projectInfo]));
        }else{
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
        }
    }

    public function addThree(Request $request) {
        $project_id = $request->get('project_id');
        $data = $this->_service->find($project_id);
        if(!$data) {
            return redirect("/project/add1")-> with('message','你还没有创建项目，请先创建项目');
        }
        if($data) {
            if($data['user_id'] !== $this->_user['id']) {
                return redirect("/")-> with('message','你无权操作此项目');
            }
            if($data['status']>1) {
           //     return redirect("/project.html?project_id=" . $project_id)-> with('message','项目已经提交,不能再编辑');
            }
        }

        if($request->method() == 'POST') {
            $this->_addThreeSave($request,$data);
        }
        return view('web.project.addthree', compact('data','beforeYear','afterYear'));
    }

    public function _addThreeSave(Request $request,$projectInfo) {
        $rules = array(
            'project_financial' => 'required',
        );
        $messages = array(
            'project_financial.required'    => '请录入财务信息',
        );
        $_request = $request->all();
        $validator = Validator::make($_request, $rules, $messages);
        if($validator->fails()){
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
        }
        $data['project_financial'] = $request->get('project_financial');

        $ok = $this->_service->update($projectInfo['id'],$data);
        if($ok) {
            return exit(json_encode(['status'=>SUCESS_CODE,'data'=>$projectInfo]));
        }else{
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
        }
    }



    public function addFour(Request $request) {
        $project_id = $request->get('project_id');
        $data = $this->_service->find($project_id);
        if(!$data) {
            return redirect("/project/add1")-> with('message','你还没有创建项目，请先创建项目');
        }
        if($data) {
            if($data['user_id'] !== $this->_user['id']) {
                return redirect("/")-> with('message','你无权操作此项目');
            }
            if($data['status']>1) {
           //     return redirect("/project.html?project_id=" . $project_id)-> with('message','项目已经提交,不能再编辑');
            }
        }

        if($request->method() == 'POST') {
            $this->_addFourSave($request,$data);
        }
        $beforeYear =beforeYear(5);
        $afterYear = afterYear(30);
        return view('web.project.addfour', compact('data','beforeYear','afterYear'));




    }

    public function _addFourSave(Request $request,$projectInfo) {
        $rules = array(
            'current_progress' => 'required',
            'land_acquisition' => 'required',
            'operating_taxes' => 'required',
            'social_capital' => 'required',
            'financing_loans_desc' => 'required',
        );
        $messages = array(
            'current_progress.required'    => '请录入项目目前进展',
            'land_acquisition.required'    => '请录入土地获取方式',
            'operating_taxes.required'    => '请录入运营期适用的税种及税率',
            'social_capital.required'    => '请录入有意向社会资本',
            'financing_loans_desc.required'    => '请录入洽过的融资机构以及贷款利率',
        );
        $_request = $request->all();
        $validator = Validator::make($_request, $rules, $messages);
        if($validator->fails()){
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
        }
        $data['supporting_plan'] = $request->get('supporting_plan');
        $data['current_progress'] = $request->get('current_progress');
        $data['land_acquisition'] = $request->get('land_acquisition');
        $data['operating_taxes'] = $request->get('operating_taxes');
        $data['social_capital'] = $request->get('social_capital');
        $data['financing_loans_desc'] = $request->get('financing_loans_desc');

        $ok = $this->_service->update($projectInfo['id'],$data);
        if($ok) {
            return exit(json_encode(['status'=>SUCESS_CODE,'data'=>$projectInfo]));
        }else{
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
        }
    }

    public function addFive(Request $request) {
        $project_id = $request->get('project_id');
        $data = $this->_service->find($project_id);
        if(!$data) {
            return redirect("/project/add1")-> with('message','你还没有创建项目，请先创建项目');
        }
        if($data) {
            if($data['user_id'] !== $this->_user['id']) {
                return redirect("/")-> with('message','你无权操作此项目');
            }
            if($data['status']>1) {
             //   return redirect("/project.html?project_id=" . $project_id)-> with('message','项目已经提交,不能再编辑');
            }
        }

        if($request->method() == 'POST') {
            $this->_addFiveSave($request,$data);
        }
        return view('web.project.addfive', compact('data','beforeYear','afterYear'));
    }




    public function _addFiveSave(Request $request,$projectInfo) {
        $rules = array(
            'pre_scheme_file' => 'required',
        );
        $messages = array(
            'pre_scheme_file.required'    => '请上传初步实施方案',
        );
        $_request = $request->all();
        $validator = Validator::make($_request, $rules, $messages);
        if($validator->fails()){
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
        }
        $data['pre_scheme_file'] = $request->get('pre_scheme_file');
        $upload_file = $request->get('other_info_file');
        if($upload_file){
            $aImg = [];
            foreach($upload_file['url'] as $key=>$img) {
                $aImg[] = ['url'=>$img,'alt'=>$upload_file['alt'][$key]];
            }
            $data['other_info_file'] = json_encode($aImg);
        }
        if($projectInfo['status']==1) {
            $data['status'] = 2;
        }
        $ok = $this->_service->update($projectInfo['id'],$data);
        if($ok) {
            return exit(json_encode(['status'=>SUCESS_CODE,'data'=>$projectInfo]));
        }else{
            return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$this->_service->getMessage()]));
        }
    }





}
