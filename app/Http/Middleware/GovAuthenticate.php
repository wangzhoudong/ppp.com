<?php namespace App\Http\Middleware;

use Closure;
use Request;

class GovAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $user = $this->_hasLogin();
        $user = $this->_hasLogin();
        if(!$user) {
            if($request->ajax()) {
                $json['status'] = NO_PERMISSION;
                $json['msg']    = '未登录';
                $json['data'] = url('login');
                exit(json_encode($json));
            }
            return redirect('/login/index')->with('message','请登录');
        }
        if($user['type'] !=3) {
            return redirect()->back()-> with('message','你无权进行改项目操作');
        }
       
        return $next($request);
    }
    
    private function  _hasLogin() {
        $user = session(LOGIN_MARK_SESSION_KEY);
        return $user;
    }
  
}
