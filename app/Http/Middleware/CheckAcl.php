<?php
namespace App\Http\Middleware;
use Closure;
use App\Services\User\Acl;
use App\Services\Admin\MCAManager;
/**
 *  用户权限验证
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年11月12日
 *
 */
class CheckAcl
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
        $param = $this->buildAclParam($request);
        $user = session(LOGIN_MARK_SESSION_KEY);
        if(isset($user['is_root']) && $user['is_root']!==true) {
            if(!isset($user['role']) || !$user['role']) {
                exit("你没有操作没有权限<a href='/logout?returnUrl=" . urlencode('http://'.$_SERVER['HTTP_HOST']) . "'>重新登录</a>");
            }
            if(!array_key_exists($param->module . "." . $param->class . "." . $param->action,$user['role'])) {
                exit("你没有操作没有权限<a href='/logout?returnUrl=" . urlencode('http://'.$_SERVER['HTTP_HOST']) . "'>重新登录</a>");
            }
        }
        $response = $next($request);
        return $response;
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

    /**
     * bind acl params
     *
     * @param object $object
     */
    private function bindAclParams($object)
    {
        return true;
        $mac = new MCAManager();
        $mac->setModule($object->module)->setClass($object->class)->setAction($object->action);
        if( ! app()->bound(MCAManager::MAC_BIND_NAME))
        {
            app()->singleton(MCAManager::MAC_BIND_NAME, function() use ($mac)
            {
                return $mac;
            });
        }
    }

}
