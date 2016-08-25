<?php
/**
 *  不允许频繁刷新的页面
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年1月29日
 *
 */
namespace LWJ\Middleware;
use Closure;

class RepeatSubmit
{
    public function handle($request, Closure $next)
    {
        $key = getCacheKey('sy_repeat' , $request->getRequestUri() . json_encode($request->all()));
        if(\Cache::get($key)) {
            if($request->ajax()) {
               $returnUrl = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : url("/");
               $json['status'] = NO_PERMISSION;
               $json['msg']    = '操作失败,请不要频繁提交';
               $json['data'] = \lwjsdk::load('ssosdk')->loginUrl($returnUrl);
               exit(json_encode($json));
            }
            exit('操作失败,请不要频繁提交');
        }
        \Cache::put($key,true,5);
        $_token = $request->get("_token");
        $_time = $request->get("_time");
        $response = $next($request);
        return $response;
    }
}
