<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'pay/callback/alipay',
        'pay/callback/wechatpay',
        'pay/callback/wechatpay_code',
        'pay/callback/tenpay',
        'api/attachment/webupload',
        'api/attachment/avatarupload',
        'api/attachment/activitysourceupload',
        'foundation-attachment-upload.do',
        'api/captcha/sendcode',



        '/api/buriedpoint',
        'api/rankinglist',
        'api/createranking',
        'api/first',
        'api/myresult',
        'api/createpricecollect',
        'api/draw',
        'api/awardslist',
        'api/awardsdetail',
        'api/getpartake',
        'api/mydrawnumber',

        'oauth/access_token',

        'service/order/virtual/list',
        'service/order/virtual/param',
        'project/add1',
    ];
}
