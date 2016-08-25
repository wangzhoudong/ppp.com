<?php namespace App\Http\Controllers\Admin\Foundation;
use Hash;
use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\AdminUsers\Process;
use App\Models\CmsArticle;
use App\Models\CmsCate;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\Admin\Login\LoginProcess;
use App\Services\User\User;
/**
 * 登录相关
 *
 */
class LoginController extends Controller
{
    private $_service;
    public function __construct() {
       $this->_service = new User();
    }
    /**
     * 登录页面，如果没有登录会显示登录页面。
     *
     * @access public
     */
    public function login()
    {
        
        return view('admin.login');
        
    }
    
    public function loginPost(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $ok = $this->_service->adminLogin($email, $password);
        if($ok) {
            return redirect("/");
        }else{
            $this->showWarning('登录失败');
        }
        
    }
    public function logout() {
        session()->forget(LOGIN_MARK_SESSION_KEY);
        session()->flush();
         return redirect('/login');
    }
    
    public function noauth() {
        echo "你没有操作没有权限<a href='/logout?returnUrl=" . urlencode('http://'.$_SERVER['HTTP_HOST']) . "'>重新登录</a>";
    }
    


}