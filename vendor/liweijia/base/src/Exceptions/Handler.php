<?php

namespace LWJ\Exceptions;
use Mail,Log;
use Exception,Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use LWJ\Utils\Logstash;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    { 

        if(env('APP_ENV') == 'production' && 
            ($e instanceof NotFoundHttpException !== true)  //404不发送
            && ($e instanceof MethodNotAllowedHttpException !==true)
            &&  ($e instanceof \UnexpectedValueException !==true)
            && $e->getMessage() != ""    //异常访问不在发送邮件
            ) {
            $_SERVER['SERVER_NAME'] = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
            $_SERVER["REQUEST_URI"] = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "";
            $data = [
                'email' => config('sys.sys_error_email'),
                'errUrl' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"],
                'errFile' => $e->getFile(),
                'errLine' => $e->getLine(),
                'errMessage' => $e->getMessage()
            ];
            if($data['errMessage']=='') {
                $data['errMessage'] = $e->getTraceAsString();
            }
            $key = md5('sys_error'.serialize($data));
            //相同的邮件不在发送
            if( \Cache::get($key)) {
                return parent::report($e);
            }
            \Cache::put($key,true,86400);
            /*
            try {
                Mail::send('email.func_email', $data, function ($message) use($data) {
                    foreach ($data['email'] as $email) {
                        $message->to($email)->subject('PPP官网程序出错啦！！！！');
                    }
                });
            } catch (Exception $e) {
                
            }*/
        }
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $this->write($request, $e);
        if(Request::ajax() and ! config('app.debug'))
        {
           return response()->json(['status' => $e->getStatusCode(),'msg'=>$e->getMessage()]);
        }
        if(!config('app.debug') && !($e instanceof HttpException)) {
            $data = ['message' => $e->getMessage()];
            return  response()->view("errors.500",$data,500);
        }
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
       
        return parent::render($request, $e);
    }
    
    public function write($request, Exception $e) {
        $str = ( '[' . date("Y-m-d H:i:s",time()) . '] ' . $e->getMessage() . '  in ' . '  File：' . $e->getFile() . '(' . $e->getLine() . ')( url in ' . $request->getRequestUri() . ")\r\n");
        
        Logstash::error($str);
        return ;
        
        $log_path = storage_path() . '/logs/' . "error-log" . date("Y-m-d") . ".log";
        
        file_put_contents($log_path, $str,FILE_APPEND);
        
    }
}
