<?php namespace LWJ\Middleware;

use Closure;
use Request;
use App\Services\User\User;
use App\Services\User\Acl;
use Illuminate\Contracts\Auth\Guard;
use App\Services\Carts\Carts;

class Authenticate
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->_hasLogin($request);
        if(!$user) {
            if($request->ajax()) {
               $returnUrl = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : url("/");
               $json['status'] = NO_PERMISSION;
               $json['msg']    = '未登录';
               $json['data'] = \lwjsdk::load('ssosdk')->loginUrl($returnUrl);
               exit(json_encode($json));
            }
            return \lwjsdk::load('ssosdk')->login( 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);
            //return redirect('/security/auth/login?returnUrl=' . urlencode('http://'.$_SERVER['HTTP_HOST'].'/'));
        }   
       
        return $next($request);
    }
    
    private function  _hasLogin($request) {

        $user = session(LOGIN_MARK_SESSION_KEY);
        if($user) {
            return $user;
        }else{

            if(env("APP_ENV") == 'testing') {
                $user =  $this->getTestUser();
                session()->put(LOGIN_MARK_SESSION_KEY, $user);
                session()->save();
                return $user;
            }
            
            $session_id = trim($request->input('PHPSESSID', 0));
            $session = session()->getHandler()->read($session_id);
            if($session){
                $session = unserialize($session);
                if(isset($session[LOGIN_MARK_SESSION_KEY])){
                    return $session[LOGIN_MARK_SESSION_KEY];
                }
            }
        }
        $user = \lwjsdk::load('ssosdk')->isLogin();
        if(!isset($user['id'])) {
            return $user;
        }
        
        $user = $this->_initUser($user);
        
        session()->put(LOGIN_MARK_SESSION_KEY, $user);
        session()->save();
        return $user;
    }
    
    
    public function _initUser($user) {
        $add['id'] = $user['id'];
        $add['name'] = isset($user['name']) ? $user['name'] : "";
        
        $add['email'] = isset($user['email']) ? $user['email'] : "";
        $add['mobile'] = isset($user['mobile']) ? $user['mobile'] : "";
        $add['type'] = isset($user['type']) ? $user['type'] : "";
        
        $obj = new User();
        $user =  $obj->create($add);
        if(!isset($user['id'])) {
            return false;
        }
        $user['is_root'] = false;
        if($user['id']===USER_ROOT_ID || $user['email'] ===USER_ROOT_EMAIL) {
            $user['is_root'] = true;
        }
        $this->_dealCart($user['id']);
        return $user;
    }
    
    public function getTestUser() {
        $obj = new User();
        $user = $obj->find('0');
        $user['is_root'] = true;
        return $user;
    }
    
    private function _dealCart($user_id) {
        $objCart = Carts::init($user_id);
        $objCart->dealCookieCart();
    }
}
