<?php
use PhpParser\Node\Expr\Array_;
/**
 *  为了方便引入一些常用函数，以及其他项目转移过来的函数，少用
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
if( ! function_exists('yimei_sms'))
{
    /**
     * @param $phone 手机号码（最多200个），多个用英文逗号(,)隔开。
     * @param $message
     * @return bool
     */
    function yimei_sms($phone, $message)
    {
        if(!$phone) {
            return false;
        }
       $url  = "http://hprpt2.eucp.b2m.cn:8080/sdkproxy/sendsms.action";
       $reqeust['cdkey'] = env("YIMEI_SMS_CDKEY");
       $reqeust['password'] = env("YIMEI_SMS_PASSWORD");
       $reqeust['phone'] = $phone;
       $reqeust['message'] = "【PPP项目】" . $message;

       $ok =  formPost($url,$reqeust);
       return true;
    }
}

/**
 * 获取当前年之前的年份
 * @param int $num
 * @return array
 */
function beforeYear($num=5) {
    $years = array();
    $currentYear = date('Y');
    $num = $num+1;
    for ($i=1; $i<$num; $i++)
    {
        $years[$i] = $currentYear - $i;
    }
    return $years;
}

/**
 * 获取当前年之后的年份
 * @param int $num
 * @return array
 */
function afterYear($num = 5) {
    $years = array();
    $currentYear = date('Y');
//    $num = $num+1;

    for ($i=0; $i<$num; $i++)
    {
        $years[$i] = $currentYear + $i;
    }
    return $years;
}

/**
 * 处理URI后斜线问题
 * @param $uri
 * @return string
 */
if( ! function_exists('formatUri'))
{
    function formatUri($uri)
    {
        $uri = trim($uri);
        if(strlen($uri) > 1){
            $uri = rtrim($uri, '/');
        }
        return $uri;
    }
}

function getMeetTime($meetTime) {
    if(!$meetTime) {
        return '';
    }
    $aMeetTime = explode(',',$meetTime);
    $str = '';
    foreach($aMeetTime as $meet) {
        $str .= dict()->get("project_info","counseling_time",$meet) . ",";
    }
    if($str){
        $str = substr($str,0,-1);
    }
    return $str;

}

/**
 * 获取时间对应的数据字典
 * @param $time
 */
function counseling_timeId($time) {
    $week = date('w',$time);
    $counseling_timeID = '';
    switch($week) {
        case "1":
        case "2":
        case "3":
        case "4":
        case "5":
            $counseling_timeID = $week;
            break;
        case "6":
            $h=date('G');
            if($h<12) {
                $counseling_timeID = "6";
            }else{
                $counseling_timeID = "7";
            }
            break;
        case "0":
            $h=date('G');
            if($h<12) {
                $counseling_timeID = "8";
            }else{
                $counseling_timeID = "9";
            }
            break;
    }
    return $counseling_timeID;
}