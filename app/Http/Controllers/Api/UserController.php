<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Validator;
use App\Services\User\UserExpert;
use App\Services\User\User;
use App\Services\User\UserGov;

class UserController extends Controller
{

    private $_service;

    function __construct()
    {
        parent::__construct();
    }



    public function expert(Request $request) {
        $_request = $request->all();
		$rules = array(
                'name'          => 'required',
                'avater'       => 'required',
                'mobile'       => 'required',
                'identiCode'       => 'required',
                'email'       => 'required',
                'territory'       => 'required',
                'education'       => 'required',
                'position'       => 'required',
                'academy'       => 'required',
                'project_desc'       => 'required',
                'resume'       => 'required',
                'undertaking'       => 'required',
                'agree'       => 'required',
        );

        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure($validator->messages()->first());
        }
        $data = $_request;
        $objUserExpert = new UserExpert();
        $user = $objUserExpert->create($data);
        if($user) {
            //登录
            $objUser = new User();
            $ok = $objUser->loginById($user->id);
            $this->toSucess('注册成功');
        }else{
            $this->toFailure($objUserExpert->getMessage());
        }
    }

    public function checkMobile(Request $request){
        $mobile = $request->get('mobile');
        $objUser = new User();
        $ok = $objUser->model()->where("mobile",$mobile)->first();
        if($ok) {
            $this->toSucess([]);
        }else{
            $this->toFailure('没有找到用户');
        }
    }

}
