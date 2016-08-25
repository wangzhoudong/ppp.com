<?php
/**
 * 
 *  处理过期的时间
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年1月14日
 *
 */
namespace App\Console;

class sendSms {
    
    /**
     * 
     * 定时发送专家短线
     * 
     */
     public static function export() {
        //需要过滤的表
         $data = \DB::table("user_info")->select("mobile")->where("status",1)->where('type',4)->get();
         foreach($data as $val) {
             yimei_sms($val->mobile,"亲爱的专家您好，PPP项目咨询平台邀请你填写下周空闲时间，方便安排项目");
         }
         return true;
     }
     

 } 