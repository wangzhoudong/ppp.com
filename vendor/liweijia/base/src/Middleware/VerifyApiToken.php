<?php
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年2月5日
 *
 */
namespace LWJ\Middleware;
use Closure;
use Illuminate\Support\Str;

class VerifyApiToken 
{
    public function handle($request, Closure $next)
    {
        $_token = $request->get("_token");
        $_time = $request->get("_time");
     /*    if(!$this->tokensMatch($request)) {
            $token  = md5(substr($request->getRequestUri(), 20). date("YmdH",$_time));
            if($_token !== $token) {
              
            }
            exit(json_encode(array('status'=>NO_PERMISSION,'msg'=>'NO_PERMISSION')));
        }  */
        $response = $next($request);
        return $response;
    }
    
    public function getMd5Token(){
        
    }
    
    protected function tokensMatch($request)
    {
        $sessionToken = $request->session()->token();
    
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
    
        if (! $token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }
        if (! is_string($sessionToken) || ! is_string($token)) {
            return false;
        }
        
        return Str::equals($sessionToken, $token);
    }
}
