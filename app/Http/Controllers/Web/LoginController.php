<?php

namespace App\Http\Controllers\Web;

use App\Services\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;
use Validator;
class LoginController extends Controller
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
        return view('web.login.index');
    }
    
    public function logout() {
        session()->forget(LOGIN_MARK_SESSION_KEY);
        session()->flush();
        return redirect('/');
    }
    
    public function gov(Request $request) {
        if($request->method() == 'POST') {
            $loginName = $request->input('loginName');
            $password = $request->input('password');
            if(!($loginName && $password)) {
                redirect()->back()-> with('message','缺少参数');
            }
            $objUser = new User();
            $ok = $objUser->login($loginName, $password);

            if($ok) {
                return redirect("/")-> with('message','登录成功');
            }else{
                redirect()->back()-> with('message',$objUser->getMessage());
            }
        }
        return view('web.login.gov');
    }

    public function resetPwd(Request $request) {
        if($request->method() == 'POST') {
            $_request = $request->all();
            $rules = array(
                'fp_loginName'          => 'required',
                'fp_password'       => 'required',
                'fp_official_remarks' => 'required'
            );
            $messages = array(
                'fp_loginName.required'    => '电话不能为空',
                'fp_password.required'    => '密码不能为空',
                'fp_official_remarks.required'    => '密码修改函不能为空',
            );

            $validator = Validator::make($_request, $rules, $messages);
            if($validator->fails()){
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
            }
            $data['reset_password'] = $request->get('fp_password');
            $data['reset_password_img'] = $request->get('fp_official_remarks');
            $objUser = new User();
            $ok  = $objUser->resetPwd($request->get('fp_loginName'),$data);

            if($ok) {
                return exit(json_encode(['status'=>SUCESS_CODE]));
            }else{
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$objUser->getMessage()]));
            }
        }
        return view('web.login.resetpwd');
    }

    public function expert(Request $request) {
        if($request->method() == 'POST') {
            return $this->_loginExpert($request);
        }
        return view('web.login.expert');
    }

    public function _loginExpert($request) {
        $mobile = $request->input("exp_mobile");
        $code = $request->input("identiCode");
        if(!($code && $mobile)) {
            redirect()->back()-> with('message','缺少参数');
        }
        $objUser = new User();
        $ok = $objUser->loginMobile($mobile,$code);
        if(!$ok) {
            return  redirect()->back()-> with('message',$objUser->getMessage());
        }
        return redirect('/')-> with('message','登录成功');

    }

}
