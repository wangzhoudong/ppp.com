<?php

namespace App\Services\Base;

use Route;

/**
 * 系统路由
 * 
 * 注：大部分的路由及控制器所执行的动作来说，
 * 
 * 你需要返回完整的 Illuminate\Http\Response 实例或是一个视图
 * 
 * @author wangzd <563808802@qq.com>
 */
class Routes
{
    private $adminDomain;

    private $wwwDomain;

    private $noPreDomain;

    /**
     * 初始化，取得配置
     *
     * @access public
     */
    public function __construct()
    {
        $this->adminDomain = config('sys.sys_admin_domain');
        $this->mobileDomain = config('sys.sys_mobile_domain');
    }

    /**
     * 后台的通用路由
     * 
     * 覆盖通用的路由一定要带上别名，且別名的值为module.class.action
     * 
     * 即我们使用别名传入了当前请求所属的module,controller和action
     *
     * <code>
     *     Route::get('index-index.html', ['as' => 'module.class.action', 'uses' => 'Admin\IndexController@index']);
     * </code>
     *
     * @access public
     */
    public function admin()
    {
        Route::group(['domain' => $this->adminDomain], function()
        {

            Route::get('/login', 'Admin\Foundation\LoginController@login');
            Route::post('/login-post','Admin\Foundation\LoginController@loginPost');
            Route::get('/logout', 'Admin\Foundation\LoginController@logout');
            Route::get('/noauth', 'Admin\Foundation\LoginController@noauth');

            Route::group(['middleware' => ['admin_auth', 'acl','alog']], function() {
                $uri =  request()->path();
                if($uri == '/') {
                    Route::any($uri, ['as' => 'admin',
                        'uses' =>'Admin\Foundation\IndexController@index']);
                }else {

                    $aUri = $baseUri = explode('/',$uri);
                    if(count($aUri)>1) {
                        unset($aUri[count($aUri)-1]);
                        $file = app_path() . '/Http/Controllers/Admin/' .implode("/",$aUri) . "Controller.php" ;
                        if(file_exists($file)) {
                            $controller = 'Admin\\' . implode("\\",$aUri) . "Controller";
                            $action =  $controller . "@" . $baseUri[count($aUri)];
                            Route::any($uri, ['as' => 'admin',
                                'uses' =>$action]);
                        }
                    }

                }

            });

        });



        return $this;
    }

    /**
     * API接口
     */
    public function api()
    {
        Route::group(['middleware' => ['api']], function()
        {
            /* API start*/
            Route::post('api/register/gov', 'Api\RegisterController@gov');
            Route::any('api/user/checkMobile', 'Api\UserController@checkMobile');
            Route::post('api/register/expert', 'Api\RegisterController@expert');

            Route::post('api/attachment/webupload', 'Api\AttachmentController@webUpload');
            //验证码
            Route::post('api/captcha/sendcode','Api\CaptchaController@sendCode');
            Route::post('/api/Project/Info/expertScore','Api\Project\InfoController@expertScore');
            Route::post('/api/Project/Info/govScore','Api\Project\InfoController@govScore');
            Route::post('/api/Project/Info/questionData','Api\Project\InfoController@questionData');
            Route::post('/api/Project/Info/questionData','Api\Project\InfoController@questionData');
            Route::post('/api/Project/Info/expertWeight','Api\Project\InfoController@expertWeight');

        });
        return $this;
    }
    
   public function mobile() {

       Route::group(['domain' => $this->mobileDomain], function()
       {


       });
      return $this;
   }


}
