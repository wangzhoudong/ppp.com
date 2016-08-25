<?php

namespace App\Http\Controllers\Web\UCenter;

use App\Services\ShopBase\ShopCoupon;
use App\Services\User\UserExpert;
use App\Services\User\UserGov;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\User\User;
use Validator;
use App\Services\UserCenter\Consignee;
use App\Services\Bi\UserWallet;

class UserController extends Controller
{
    private $_service;

    private $_userInfo;

    public function __construct() {
        parent::__construct();

        if ( !$this->_service ) $this->_service = new User();
        $this->_userInfo = $this->_service->find($this->_user['id']);
        view()->share('_userInfo', $this->_userInfo);
    }

    /**
     * 个人中心首页
     */
    public function index() {
        return view('ucenter.user.index', compact('data'));
    }

    /**
     * 用户基础信息
     */
    public function userInfo(Request $request) {

        switch($this->_userInfo['type']) {
            case "3":
                return $this->govInfo($request);
                break;
            case "4":
                return $this->expertInfo($request);
                break;
            default:
                exit("敬请期待");
                break;
        }
    }

    public function govInfo($request) {
        if($request->method() == 'POST'){
            //验证必填参数
            $_request = $request->all();
            $rules = array(
                'itemName'          => 'required',
                'company_tel'       => 'required',
                'linkman'       => 'required',
                'linkman_mobile'       => 'required',
            );

            $validator = Validator::make($_request, $rules);
            if($validator->fails()){
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
            }
            $data['project_name'] = $request->get('itemName');
            $data['department'] =$request->get('builder_company');
            $data['linkman_tel'] = $request->get('company_tel');
            $data['linkman_email'] = $request->get('linkman_email');
            $data['linkman'] = $request->get('linkman');
            $data['linkman_mobile'] = $request->get('linkman_mobile');
            $data['pre_scheme'] = $request->get('pre_scheme');
            $data['other_info'] =$request->get('other_info');
            $objUserExpert = new UserGov();
            $ok =  $objUserExpert->update($this->_user['id'], $data);
            if($ok) {
                return exit(json_encode(['status'=>SUCESS_CODE]));
            }else{
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$objUserExpert->getMessage()]));
            }
        }
        return view('web.ucenter.user.account.gov', compact('data'));

    }
    public function expertInfo($request) {
        if($request->method() == 'POST'){
            //验证必填参数
            $_request = $request->all();
            $rules = array(
                'name'          => 'required',
                'avater'       => 'required',
                'email'       => 'required',
                'territory'       => 'required',
                'education'       => 'required',
                'position'       => 'required',
                'academy'       => 'required',
                'project_desc'       => 'required',
                'resume'       => 'required',
            );
            $validator = Validator::make($_request, $rules);
            if($validator->fails()){
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$validator->messages()->first()]));
            }
            $_request['meet_time'] = implode(',',$request->get('meet_time'));
            $objUserExpert = new UserExpert();
            $ok =  $objUserExpert->update($this->_user['id'], $_request);
            if($ok) {
                return exit(json_encode(['status'=>SUCESS_CODE]));
            }else{
                return exit(json_encode(['status'=>FAILURE_CODE,'msg'=>$objUserExpert->getMessage()]));
            }
        }

        if($this->_userInfo['type'] != 4) {
            abort(404);
        }

        return view('web.ucenter.user.account.expert', compact('data'));
    }



}
