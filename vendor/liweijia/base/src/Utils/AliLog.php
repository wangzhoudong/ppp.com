<?php
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年3月29日
 *
 */
namespace LWJ\Utils;
include_once base_path() . "/vendor/aliyuncs/sls-sdk-php/Log_Autoload.php";

class AliLog {
    
    private  $_client;
    
    private  $_project;
    
    public function __construct() {
        $accessKeyId = config('aliyun.access_id');
        $accessKey   = config("aliyun.access_key");
        $endpoint    = config('aliyun.sls_endpoint');
        $this->_project = config('aliyun.sls_project');
        $token       = '';
        $this->_client = new \Aliyun_Log_Client($endpoint, $accessKeyId, $accessKey,$token);
    }
    
    
    
    /**
     * 
     * @param string $LogStore 对应阿里云LogStore
     * @param unknown $topic 日志主题
     * @param unknown $contents 日志内容 key=>value格式
     */
    public  function put($logstore,$topic,array $contents) {
        
       
        $logItem = new \Aliyun_Log_Models_LogItem();
        $logItem->setTime(time());
        $logItem->setContents($contents);
        $logitems = array($logItem);
        $request = new \Aliyun_Log_Models_PutLogsRequest($this->_project, $logstore,
            $topic, null, $logitems);
        try {
            $response = $this->_client->putLogs($request);
            return true;
        } catch (\Aliyun_Log_Exception $ex) {
            $this->message = $ex;
        } catch (\Exception $ex) {
            $this->message = $ex;
        }
        return false;
    }
    
    /**
     * 阿里云日志查询
     *
  
     * @param string $logstore
     *            日志类型
     * @param string $topic
     *            主题
     * @param int $from
     *            开始的时间
     * @param int $to
     *            结束时间            
     * @param array $query
     *            查询关键字
     * @param int $line
     *         查询行数
     * @param  int $offset 
     *         开始行数
     *          
     * @param bool $reverse 
     *            是否倒叙          
     *               
     */
    public function listLogs($logstore = null, $from = null, $to = null, $topic = null, $query = null, $line = null, $offset = null, $reverse = null) {
//         $topic = 'TestTopic';
//         $from = time()-3600;
//         $to = time();
        $request = new \Aliyun_Log_Models_GetLogsRequest($this->_project, $logstore, $from, $to, $topic,$query, $line, $offset, $reverse);
        
        try {
            $response = $this->_client->getLogs($request);
            return $response;
        } catch (\Aliyun_Log_Exception $ex) {
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
    
    
    
    
}