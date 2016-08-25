<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Validator;
use App\Services\User\UserExpert;
use App\Services\User\User;
use App\Services\User\UserGov;

class RegisterController extends Controller
{

    private $_service;

    function __construct()
    {
        parent::__construct();
    }


    public function gov(Request $request) {
        $_request = $request->all();
        $rules = array(
            'itemName'          => 'required',
            'builder_company'       => 'required',
            'company_tel'       => 'required',
            'loginName'       => 'required',
            'linkman'       => 'required',
            'linkman_mobile'       => 'required',
            'approve_pic'       => 'required',
            'password'       => 'required',
            'agree'       => 'required',
        );

        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure($validator->messages()->first());
        }
        $data['project_name'] = $request->get('itemName');
        $data['department'] = $request->get('builder_company');
        $data['linkman_tel'] = $request->get('company_tel');
        $data['username'] = $request->get('loginName');
        $data['linkman_email'] =$request->get('linkman_email');
        $data['linkman'] = $request->get('linkman');
        $data['linkman_mobile'] = $request->get('linkman_mobile');
        $data['approve_pic'] = $request->get('approve_pic');
        $data['password'] = $request->get('password');
        $objUserGov = new UserGov();
        $user = $objUserGov->create($data);
        if($user) {
            //登录
//            $objUser = new User();
//            $ok = $objUser->loginById($user->id);
            $this->toSucess('注册成功');
        }else{
            $this->toFailure($objUserGov->getMessage());
        }
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
        if(request('identiCode') != session('mobile_authcode')) {
            $this->toFailure("验证码不正确");
            return false;
        }
        $validator = Validator::make($_request, $rules, []);
        if($validator->fails()){
            $this->toFailure($validator->messages()->first());
        }
        $data = $_request;
        $objUserExpert = new UserExpert();
        $user = $objUserExpert->create($data);
        if($user) {
            //登录
//            $objUser = new User();
//            $ok = $objUser->loginById($user->id);
            $this->toSucess('注册成功');
        }else{
            $this->toFailure($objUserExpert->getMessage());
        }
    }

}
