<?php
/**
 * 
 *  处理过期的时间
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年1月14日
 *
 */
namespace App\Console;

class dealRecycleData {
    
    /**
     * 
     * 删除过期的表数据
     * 
     */
     public static function table() {
        //需要过滤的表
        $except = ['jobs','migrations'];
         echo "删除过期数据..";
         $deleteTime =  date('Y-m-d H:i:s',time()-86400*config('sys.deal_recycle_data_day',30));
         $tables = \DB::select('SHOW TABLES');
         foreach ($tables as $table) {
             $table = current(get_object_vars($table));
             if(!in_array($table, $except)) {
                 
                 $ok = \DB::table($table)->where("deleted_at","<",$deleteTime)->delete();
             }
         } 
         return true;
     }
     
     /**
      * 定时删除过期文件（包括日志文件）
      * 
      */
     public static function file() {
         //需要过滤的文件
         $except = ['.','..','.gitignore','.svn','readme.txt'];
        //删除日志文件
         $deleteTime = time() - 86400*10;//删除过期的日志文件
         self::_rmFile(storage_path() . "/logs/", $deleteTime);
         self::_rmFile(public_path() . "/temp/", $deleteTime);
     }
     
     private static  function _rmFile($path,$deleteTime,$except= ['.','..','.gitignore','.svn']) {
         foreach (scandir($path) as $dir) {
             if(!in_array($dir, $except)) {
                 $filePath = $path . $dir;
                 $fileatime = filemtime($filePath);
                 if($fileatime<$deleteTime) {
                     if(is_dir($filePath)) {
                         \File::deleteDirectory($filePath);
                     }else{
                         echo 'rmfile ' . $filePath . "\r\n";
                         unlink($filePath);
                     }
                 }
             }
         }
         return true;
     }
     
 } 