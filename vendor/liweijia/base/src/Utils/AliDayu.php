<?php
/**
 *  阿里大于
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年3月29日
 *
 */
namespace LWJ\Utils;

include_once base_path() . "/vendor/aliyuncs/dayu-sdk-php//TopSdk.php";

class AliDayu {

    /**
     * 
     * @param String $mobile 短信接收号码。支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，一次调用最多传入200个号码。示例：18600000000,13911111111,13322222222
     * @param Array $smsParam 短信模板变量，传参规则{"key":"value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开。示例：针对模板“验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！”，传参时需传入{"code":"1234","product":"alidayu"}
     
     * @param string $tpl 短信模板ID，传入的模板必须是在阿里大鱼“管理中心-短信模板管理”中的可用模板。示例：SMS_585014
     
     * @param string $signName 短信签名，传入的短信签名必须是在阿里大鱼“管理中心-短信签名管理”中的可用签名。如“阿里大鱼”已在短信签名管理中通过审核，则可传入”阿里大鱼“（传参时去掉引号）作为短信签名。短信效果示例：【阿里大鱼】欢迎使用阿里大鱼服务。
     
     */
    public static function sendSms($mobile,$tpl,$signName,$smsParam=[]) {
        $appkey= config('aliyun.dayu_appkey');
        $secret = config('aliyun.dayu_secret');
        $c = new \TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($signName);
        $req->setSmsParam(json_encode($smsParam));
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode($tpl);
        $resp = $c->execute($req);

        if(isset($resp->result->err_code) && $resp->result->err_code->__toString() === '0') {
            $return = ['status'=>SUCESS_CODE,'msg'=>$resp->msg->__toString()];
        }else{
            $return = ['status'=>FAILURE_CODE,'msg'=>$resp->sub_msg->__toString()];
        }

        //添加发送记录
        $data = [
            'content' => implode(',', $smsParam),
            'mobile' => $mobile,
            'status' => $return['status'],
            'return_msg' => $return['msg'],
        ];
        $objSms = new \App\Services\Sms\Sms;
        $objSms->create($data);

        return $return;
    }
    
}