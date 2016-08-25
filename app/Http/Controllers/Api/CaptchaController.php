<?php
/**
 *  验证码
 *  @author  qqiu@qq.com
 *  @version    1.0
 *  @date 2016年4月12日
 *
 */

namespace App\Http\Controllers\Api;

use App\Utils\CheckUtils;
use Illuminate\Http\Request;
use App\Http\Requests;
use LWJ\Utils\AliDayu;
class CaptchaController extends Controller
{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 发送验证码
     */
    public function sendCode () {
        $mobile = request('mobile');
        if(!CheckUtils::isMobile($mobile)) {
            $this->toFailure('请输入正确的手机号');
        }
        $key = "mobile_authcode" . $mobile;
        if(\Cache::get($key)) {
            $this->toFailure('请稍后再尝试发送短信');
        }

        $code = mt_rand(1000, 9999);
        session(['mobile_authcode' => $code]);
        session()->save();
        $ok =  yimei_sms($mobile,"验证码$code");
//        $message = AliDayu::sendSms($mobile, 'SMS_7765080', '丽维家', ['product' => '提现申请', 'code' => trim($code)]);
//        if($message['status'] != SUCESS_CODE){
//            $this->toFailure('信息发送失败，请稍后重试');
//        }
        //\Cache::put($key,true,60);
        $this->toSucess('发送成功');
    }

}
