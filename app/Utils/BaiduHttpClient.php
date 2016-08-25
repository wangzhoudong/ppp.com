<?php
/**
 *  Baidu HTTP 定制化请求工具 
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年11月3日
 *
 */
namespace App\Utils;

class BaiduHttpClient
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    
    public static $timeout = 10; //超时时间
    
    /**
     * 普通GET请求
     *
     * @param string $url 请求地址
     * @param array $query GET变量数组
     * @param array timeout   超时时间
     * return string
     */
    public static function query($url, array $query = array(),$timeout=null)
    {
        $options = array();
        if($timeout !== null) {
            $options['timeout'] = $timeout;
        }
        
        return self::createCurlResource($url, self::GET, $query,null,array(),$options);
    }


    /**
     * 普通POST请求
     *
     * @param string $url 请求地址
     * @param array $query GET变量数组
     * @param array $request POST变量数组
     * @param array $files 要上传的文件数组
     *
     * @return string
     */
    public static function request($url, array $query, array $request, array $files = array())
    {
        return self::createCurlResource($url, self::POST, $query, $request, $files);
    }
    
   public static function put($url, array $query, array $request){
       return self::createCurlResource($url, self::PUT, $query, $request);
   }
   
   public static function delete($url, array $query, array $request){
       return self::createCurlResource($url, self::DELETE, $query, $request);
   }
  

    /**
     * POST一个原始数据，该类型请求无法上传文件
     *
     * @param string $url 请求地址
     * @param array $query GET变量数组
     * @param string $request POST数据
     *
     * @return string
     */
    public static function requestRawData($url, array $query, $request)
    {
        return self::createCurlResource($url, self::POST, $query, $request);
    }

    /**
     * 发起一个HTTP请求并将响应的数据返回
     *
     * @throws HttpRequestException 发起请求失败时返回抛出该异常
     * @throws HttpResponseException 当微信服务器响应了一个非200的状态码时抛出该异常
     *
     * @param string $url 请求地址
     * @param string $method 请求方式
     * @param array $query GET变量数组
     * @param array|string $request POST变量数组或数据
     * @param array $files 要上传的文件
     * @param array $options   参数
     *              timeout  超时时间
     * @return array 返回一个数组，数组的第一项是响应的Content-Type，第二项是响应的内容
     */
    private static function createCurlResource($url, $method, array $query, $request = null, array $files = array(),$options=array())
    {
        $timeout = isset($options['timeout']) ? $options['timeout'] : self::$timeout;
        $aUrl = parse_url($url);
        $curl = curl_init(self::rebuildUrl($url, $query));
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::getHeader());
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
//         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if($request) {
            if (is_array($request)) {
                foreach ($files as $name => $path) {
                    $request["$name"] = '@'.$path;
                }
            }
            if (is_string($request) && !empty($files)) {
                // throw new Exception(sprintf('%s: 请选择你要提交的数据', __CLASS__));
            }
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt ($curl, CURLOPT_CUSTOMREQUEST, $method );
            $request = json_encode($request);
            
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        }
       
        
        $responseText = curl_exec($curl);
        if (false === $responseText) {
//             throw new Exception(sprintf('%s: send http request failed: %s', __CLASS__, $url));
        }
        $responseStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($responseStatus != 200) {
//             throw new Exception($responseStatus, sprintf('%s:server response error: status=%s', __CLASS__, $responseStatus));
//             var_dump(curl_error($curl));exit;
        }
       
        $contentType = strtolower(curl_getinfo($curl, CURLINFO_CONTENT_TYPE));
        curl_close($curl);
        return $responseText;
    }

    /**
     * 根据参数重建URL
     *
     * @throws InvalidArgumentException 当不是一个合法的URL是抛出
     *
     * @param string $url 原始URL
     * @param array $query GET变量数组
     *
     * @return string
     */
    public static function rebuildUrl($url, array $query = array())
    {
        $urlInfo = parse_url($url);
        if (!$urlInfo || !isset($urlInfo['scheme']) || !isset($urlInfo['host'])) {
            throw new InvalidArgumentException(sprintf('%s: Invalid request url: %s', __CLASS__, $url));
        }

        $queryString = '';
        if (isset($urlInfo['query']) && $urlInfo['query'] !== '') {
            $queryString = $urlInfo['query'];
            $queryString = substr($queryString, -1) === '&' ? substr($queryString, 0, -1) : $queryString;
        }

        if (!empty($query)) {
            $queryString.= $queryString === '' ? http_build_query($query) : ('&'.http_build_query($query));
        }

        // 这里忽略了除scheme、host、path、query之外的参数，也忽略了除HTTP和HTTPS之外的协议

        $url = $urlInfo['scheme'].'://'.$urlInfo['host'];
        $url.= isset($urlInfo['path']) ? $urlInfo['path'] : '';
        $url.= $queryString === '' ? '' : ('?'.$queryString);

        return $url;
    }
    
    private static function getHeader() {
        $headers = array(
            'Content-Type' => 'text/json;charset=utf-8', // 设置为Ajax方式
            'apikey' => config("sys.baidu_api_key"), // 设置为Ajax方式
        );
        $headerArr = array();
        foreach( $headers as $n => $v ) {
            $headerArr[] = $n .':' . $v;
        }
        return $headerArr;
    }
}