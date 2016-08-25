<?php
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年3月16日
 *
 */

namespace LWJ\Utils;
include_once base_path() . '/vendor/aliyuncs/mns-sdk-php/mns-autoloader.php';

use AliyunMNS\Client;
use AliyunMNS\Requests\SendMessageRequest;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Exception\MnsException;

class AliQueue {
    
    private $_msg = '';
    
    protected $_queueName;
    
    public function __construct($queueName) {
        $this->_queueName = $queueName;   
    }
    
    public function client() {
        $accessId = config('aliyun.access_id');
        $accessKey = config('aliyun.access_key');
        $endPoint = config('aliyun.mns_endpoint');
        $this->client = new Client($endPoint,$accessId, $accessKey);
        return $this->client;
    }
    
    public function getMsg() {
        return $this->_msg;
    }
    /**
     * 创建队列
     * @return boolean
     */
    public function create() {
        
        $request = new CreateQueueRequest($this->_queueName);
        try
        {
            $res = $this->client()->createQueue($request);
            return true;
        }
        catch (MnsException $e)
        {
            $this->_msg = "CreateQueueFailed: " . $e;
            return false;
        }
    }
    /**
     * 发送消息
     * @param unknown $msg
     * @return boolean
     */
    public function sendMessage($msg) {
      
        $queue = $this->client()->getQueueRef($this->_queueName);
        
//         $bodyMD5 = md5(base64_encode($msg));
        $request = new SendMessageRequest($msg);
        
        try
        {
            $res = $queue->sendMessage($request);
            return true;
        }
        catch (MnsException $e)
        {
            $this->_msg = $e;
            return false;
        }
    }
   
    /**
     * 接受消息
     * @param string $delete
     * @return \AliyunMNS\ReceiveMessageResponse:|boolean
     */
    public function receiveMessage($delete = false) {
        $queue = $this->client()->getQueueRef($this->_queueName);
        $receiptHandle = NULL;
        try
        {
            $res = $queue->receiveMessage();
            if($delete) {
                $receiptHandle = $res->getReceiptHandle();
                $queue->deleteMessage($receiptHandle);
            }
            return $res['messageBody'];
        }
        catch (MnsException $e)
        {
            $this->_msg = $e;
            return false;
        }
    }
    
    
    
}