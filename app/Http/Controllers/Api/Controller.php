<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Request;
/**
 * 父控制类类
 *
 * @author wangzhoudong <wangzhoudong@liweijia.com>
 */
abstract class Controller extends BaseController
{
   protected $status = FAILURE_CODE;
   protected $msg = '';
   protected $data = null;
   public function __construct(){
       if(!Request::ajax()) {
           $this->status = SERVER_ERROR;
           //$this->output();
       }
       $this->_user = session(LOGIN_MARK_SESSION_KEY);
      
       parent::__construct();
   }
   
   /**
    * 正确返回数据
    * @param unknown $data
    */
   protected function toSucess($data) {
       $this->status  =  SUCESS_CODE;
       $this->data = $data;
       $this->output($data);
   }
   protected function toFailure($msg) {
       $this->status  =  FAILURE_CODE;
       $this->msg = $msg;
       $this->output();
   }
   protected function output() {
       header('Content-type: application/json');
       //解决跨域问题
       header("Access-Control-Allow-Origin:" . env('IMAGES_URL','http://img-staging.liweijia.com/'));
       $arr['status']  =  $this->status;
       $arr['msg']  = $this->msg;
       $arr['data'] = $this->data;
       $_callback = request()->get("callback");//JSONP
       if($_callback) {
           exit($_callback . '(' .  json_encode($arr) . ')');
       }else{
           exit(json_encode($arr));
       }
   }
  
}
