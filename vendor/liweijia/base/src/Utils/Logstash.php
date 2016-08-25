<?php
/**
 *
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年3月29日
 *
 */
namespace LWJ\Utils;
use Illuminate\Support\Facades\Redis;


class Logstash {

    private static $_logRedis;



    private static function _client() {
       if(!env('LOG_REDIS')) {
            return false;
       }
       if(!self::$_logRedis) {
//           echo '链接reids';
            self::$_logRedis = Redis::connection('log');
       }
       return self::$_logRedis;
       
    }

    /**
     *
     * test
     *
     * $contents['user_id'] = 0;
    $contents['user_name'] = 'name';
    $contents['operator'] = 'admin@liwei.com';
    $contents['module'] = 'admin';
    $contents['class'] = 'class';
    $contents['action'] = 'action';
    $contents['url'] = 'http://llasdfkadfjalsdf/' ;
    $contents['method'] = "GET";
    $contents['request_data'] = 'asdfasdfasdfasdfasdfasdf' ;
    $contents['md5'] = md5($arr['user_id'] . $arr['module'] . $arr['class'] . $arr['action'] . $arr['url'] . $arr['method'] . $arr['request_data']) ;
     * @param string $LogStore 对应日子类型
     * @param unknown $topic 日志主题
     * @param unknown $contents 日志内容 key=>value格式
     */
    public static function put($logstore,$topic,array $contents) {
        if(!self::$_logRedis) {
           if(!self::_client()) {
               return true;
           }
        }
        if(env('APP_ENV') == 'production') {
            $prefix = 'live:';
        }else{
            $prefix = "staging:";
        }
        $contents['@app'] = env('APP_NAME','www');
        $contents['@logstore'] = $logstore;
        $contents['@topic'] = $topic;
        $ok = self::$_logRedis->lpush($prefix . 'logstash:business-log',json_encode($contents));
        return $ok;
    }
    
    public static function info($contents) {
        return self::put(config('logstore.debug'),'info', ['content'=>print_r($contents,true)]);
    }
    
    public static function error($contents) {
        return self::put(config('logstore.debug'),'error', ['content'=>print_r($contents,true)]);
    }
    
    public static function msg($contents) {
        return self::put(config('logstore.debug'),'msg', ['content'=>print_r($contents,true)]);
    }
    


}