<?php

namespace App\Http\Controllers\Web;
use App\Services\Promotion\Tracking;
use Request,Cache;
use App\Http\Controllers\Controller as BaseController;
use Log;
use App\Services\Carts\Carts;
use App\Services\CmsMeta\CmsMeta;
use App\Services\Campaign\Campaign;
use App\Services\User\User;

abstract class Controller extends BaseController
{
    protected $_user;
    protected $_seo = array();
    
    private $_isConstruct;

    public function __construct() {
        //推广来源

        if(!$this->_isConstruct) {
            $this->_user = session(LOGIN_MARK_SESSION_KEY);
            if($this->_user) {
                $this->_user = (new User())->find($this->_user['id']);
            }
            view()->share('_user', $this->_user);
            $this->_initSeo();
            //获取前端编辑权限
            if(request()->input('front_key')){
                //注册前端SESSION
                $this->_registerFrontSession(request()->input('front_key'));
                //重定向
                header("Location:http://" . config('sys.sys_www_domain') . "/");
                exit;
            }
            //设置前端内容管理开启状态
            if(isset($this->_readBySessionId(csrf_token())['editable'])) {
                view()->share('_editable', 1);
            }
            view()->share('page_param', $this->_getPageParamData());
            $this->_isConstruct = true;

        }

    }


    /**
     * 自动跳转品台并跳转
     */
    protected function checkPlatformGo() {
        if(isMobile()) {
            $url = "http://" . config('sys.sys_mobile_domain') .  "/"  . ltrim(request()->getRequestUri(),'/');
            header("Location:$url");
            exit;
            redirect($url);
        }
    }


    /**
     * 注册前端SESSION
     * @param $session_id
     */
    private function _registerFrontSession($session_key) {
        //获取后台SESSION
        $session = $this->_readBySessionId($session_key);
        if(isset($session[LOGIN_MARK_SESSION_KEY])){
            //如果权限存在，注册前端session

            if($this->_checkEditPermissions($session[LOGIN_MARK_SESSION_KEY])){
                session()->getHandler()->write(csrf_token(), serialize(['editable' => 1]));
                //更新后台session
                $session[LOGIN_MARK_SESSION_KEY]['front_session_id'] = csrf_token();
                session()->getHandler()->write($session_key, serialize($session));
            }
        }
    }

    /**
     * 验证前台编辑权限
     * @param $session
     */
    private function _checkEditPermissions($session) {
        $roles = isset($session['role']) ? $session['role'] : [];
        if(isset($roles['Operate/Page/index']) && isset($roles['Operate/Page/update'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 读取SESSION
     */
    private function _readBySessionId($session_id){
        $session = session()->getHandler()->read($session_id);
        if($session) $session = unserialize($session);
        return $session;
    }

    private function _getPageParamData() {
        $page = trim(request()->getRequestUri());
        if(strlen($page) > 1){
            $page = rtrim($page, '/');
        }
        $cacheKey = 'widget_page_key_get_' . urlencode($page);
        if($data = \Cache::get($cacheKey)) {
            return $data;
        }

        $model_page = new \App\Services\ModulePage\ModulePage();
        $data = $model_page->getDataByPage($page)->toArray();
        $content = [];
        if(!empty($data)) {
            foreach($data AS $val){
                $content[$val['key']] = $val['content'];
            }
        }

        \Cache::put($cacheKey,$content,86400);
        return $content;
    }


    private function _initSeo() {
        if(!$this->_seo){
            $meta = \Cache::remember('web_seo_meta' . request()->getRequestUri(), 86400, function() {
                $obj = (new CmsMeta())->get(['page' => request()->getRequestUri()]);
                $meta = $obj?$obj->toArray():['title' => '', 'keywords' => '','description' => '',];
                return $meta;
            });
            $this->_seo['page_title'] = $meta['title'];
            $this->_seo['meta_keyword'] = $meta['keywords'];
            $this->_seo['meta_description'] = $meta['description'];
        }
        view()->share('_seo', $this->_seo);
    }

}
