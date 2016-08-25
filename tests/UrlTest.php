<?php
use Illuminate\Http\Response;
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年1月12日
 *
 */
class UrlTest extends TestCase
{
   
    public function testWebUrl(){
        //单独不带数据的GET
        $aUrl = array( '',

        );
        
        $baseUrl = "http://" . env('WWW_DOMAIN') . '/';
        foreach ($aUrl as $uri) {
            $url = $baseUrl . $uri;
            $this->assertUrl($url);
        }
            // 判断需要跳转的页面（如登录）
        $aUrl = ['user/index',
        ];
        
        foreach ($aUrl as $uri) {
            $url = $baseUrl . $uri;
            $this->assertUrl($url,"GET","302");
        }
    }
    
    
    public function testAdminUrl(){
        // 判断需要跳转的页面（如登录）
        $aUrl = ['',
        ];
        $baseUrl = "http://" . env('ADMIN_DOMAIN') . '/';
        foreach ($aUrl as $uri) {
            $url = $baseUrl . $uri;
            $this->assertUrl($url,"GET","302");
        }
    }

   
    
}