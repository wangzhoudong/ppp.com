<?php

return [
    'deal_recycle_data_day' => 30, //多少天清空一次回收站的数据
    
    'version'     =>env('APP_DEBUG')==true ?  "text"/*time()*/ : "1.1.0",// 如果debug模式则不启用缓存
    //文件服务器路径，必须以http://开头
    'sys_file_url' => env('FILE_URL','http://liweijia-test.oss-cn-beijing.aliyuncs.com/'),
        
    //图片服务器路径，必须以http://开头
    'sys_images_url' => env('IMAGES_URL','http://img-staging.ppp.com/'),

	'sys_static_url' => env("STATIC_URL"),
    //后台访问域名，不用http://开头
    'sys_admin_domain' => env('ADMIN_DOMAIN','webadmin.ppp.com'),

    //WEB访问域名
    'sys_www_domain' => env('WWW_DOMAIN','www.ppp.com'),
        
    //手机访问域名
    'sys_mobile_domain' => env('MOBILE_DOMAIN','m.ppp.com'),

    //访问域名无前缀
    'sys_www_nopre_domain' => env('WWW_NOPRE_DOMAIN','ppp.com'),

    //前端SESSON的KEY
    'front_session_key' => env('FRONT_SESSION_KEY', 'LSWgHwapIhWw15miiUwjB7ydvySgTtd9y6S6vZH9'),

    //上传的路径，包括ueditor的上传路径也在这里定义了，因为修改了ueditor，重新加载了这个文件。
    'sys_upload_path' => __DIR__ . '/../../upload_path',

    //水印图片
    'sys_water_file' => __DIR__ . '/../storage/water/water.png',
    'sys_error_email'=>['wangzhoudong@foxmail.com'],
    //不需要验证权限的功能，*号代表全部,module不能为*号
    'access_public' => [
        ['module' => 'foundation', 'class' => 'index', 'function' => '*'],
        ['module' => 'foundation', 'class' => 'user', 'function' => ['mpassword']],
        ['module' => 'foundation', 'class' => 'upload', 'function' => ['process']],
    ],
    //百度API key
    'baidu_api_key' => '526eb7c05625bf9d0eb2f19aca94a858',
];