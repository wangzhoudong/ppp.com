<?php namespace App\Http\Middleware;

use Closure;
use App\Models\LogAdminOperateModel;
use App\Utils\AliLog;

/**
 * 用户操作日志
 *
 * @author wangzhoudong <wangzhoudong@liweijia.com>
 */
class ActionLog
{
    //需要过滤的action
     protected $except = [
        //
        'foundation.index.index',
        'foundation.index.welcome',
    ];
     
   
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->log($request);
        $response = $next($request);
        return $response;
    }

    /**
     * 写入日志
     */
    private function log($request)
    {
        $objectAcl = $this->buildAclParam($request);
        if(in_array($objectAcl->module . "." . $objectAcl->class . "." . $objectAcl->action,$this->except)) {
            return true;
        }
        
        $user = session(LOGIN_MARK_SESSION_KEY);
        $requestData = $request->all();
        if($requestData) {
            $requestData = json_encode($requestData);
        }else{
            $requestData = '';
        }
        
        $arr['user_id'] = $user['id'];
        $arr['user_name'] = $user['name'];
        $arr['operator'] = $user['email'] ? $user['email'] :  $user['mobile'];
        $arr['module'] = $objectAcl->module;
        $arr['class'] = $objectAcl->class;
        $arr['action'] = $objectAcl->action;
        $arr['url'] = $request->getRequestUri() ;
        $arr['method'] = $request->method() ;
        $arr['request_data'] = $requestData ;
        $arr['md5'] = md5($user['id'] . $arr['module'] . $arr['class'] . $arr['action'] . $arr['url'] . $arr['method'] . $arr['request_data']) ;
       
        $obj = new AliLog();
        if($arr['method'] == "GET") {
            $topic =  'action-view-log';
        }else{
            $topic =  'action-operate-log';
        }
        
        $obj->put(config('sys.sys_admin_logstore'), $topic, $arr);
        $obj = new LogAdminOperateModel();
        $obj->create($arr);
    }

    
    /**
     * buildAclParam
     *
     * @param object $repuest
     */
    private function buildAclParam($request)
    {
        $object = new \stdClass();
        $object->class = $request->route('class');
        $object->action = $request->route('action');
        $object->module = $request->route('module');
        if( ! $object->class and ! $object->action and ! $object->module)
        {
            $currentRouteName = $request->route()->getName();
            $currentRouteNameArr = explode('.', $currentRouteName);
            if(isset($currentRouteNameArr[2]))
            {
                $object->module = $currentRouteNameArr[0];
                $object->class = $currentRouteNameArr[1];
                $object->action = $currentRouteNameArr[2];
            }else{
                $object->module = 'foundation';
                $object->class = 'index';
                $object->action = 'index';
            }
        }
        return $object;
    }
    

}
