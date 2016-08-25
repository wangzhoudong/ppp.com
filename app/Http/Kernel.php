<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'App\Http\Middleware\Authenticate',
        'admin_auth' => \App\Http\Middleware\AdminAuthenticate::class,
        'gov_auth' => \App\Http\Middleware\GovAuthenticate::class,
        'acl' => \LWJ\Middleware\CheckAcl::class,
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        'alog' =>  \LWJ\Middleware\ActionLog::class,
        'repeat' => \App\Http\Middleware\RepeatSubmit::class,
        'api' => \App\Http\Middleware\VerifyApiToken::class,
        'api' => \App\Http\Middleware\VerifyApiToken::class,
    ];
}
