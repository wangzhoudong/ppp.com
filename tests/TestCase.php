<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://local.ppp.com';
   
    
   
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    public function getHttpStatus($url,$method = 'GET') {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,$method);
        $result = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $statusCode;
           
    }
    
    /**
     * 检查URL状态是否能访问，可以判断文件是否存在
     */
    public function assertUrl($url,$method = 'GET',$httpCode=200) {
        $statusCode = $this->getHttpStatus($url,$method = 'GET');
        $this->assertEquals($statusCode, $httpCode,$url . ' statusCode:' . $statusCode);
    }
    
}
