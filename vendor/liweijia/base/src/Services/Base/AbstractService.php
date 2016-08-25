<?php 
namespace LWJ\Services\Base;

use LWJ\Utils\Logstash;
/**
 * 服务基类
 *
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 */
abstract class AbstractService
{
   protected $_code = FAILURE_CODE;
    
    /**
     * 错误的信息载体
     *
     * @access protected
     */
    protected $_msg;
    
    /**
     * 取回错误的信息
     *
     * @access public
     */
    public function getMessage()
    {
        return $this->_msg;
    }
   
    
    /**
     * 设置错误的信息
     *
     * @param string $errorMsg 错误的信息
     */
    public function setMsg($msg)
    {
    	$this->_msg = $msg;
    	return false;
    }
    /**
     * 设置错误码
     */
    public function setCode($code) {
        $this->_code = $code;
    }
    
    /**
     * 标记为成功
     */
    public function setSucessCode() {
        $this->setCode(SUCESS_CODE);
    }
}
