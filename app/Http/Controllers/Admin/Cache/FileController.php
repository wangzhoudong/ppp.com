<?php
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2016年1月18日
 *
 */

namespace App\Http\Controllers\Admin\Cache;


use App\Http\Controllers\Admin\Controller;

//xxxhooktest
class FileController extends Controller
{
     /**
     * 清除cache
     */
      public function clearcache() {
          $filePath = storage_path() . "/framework/cache/";
          \File::cleanDirectory($filePath);
          exit('操作成功');
      }   
      
      /**
       * 清除试图缓存
       */
      public function clearview() {
          $filePath = storage_path() . "/framework/views/";
          \File::cleanDirectory($filePath);
          exit('操作成功');
      }
    
      /**
       * 强制在线用户下线
       */
      public function clearsessions() {
          $filePath = storage_path() . "/framework/sessions/";
          \File::cleanDirectory($filePath);
          exit('操作成功');
      }
      
      /**
       * 文件查看
       */
      public function index() {
          $fileDir = request('dir','');
          $filePath = storage_path() . "/" . $fileDir ;
          foreach (scandir($filePath) as $dir) {
               
               
              $dirPath = $filePath . "/"  . $dir;
              if(in_array($dir, array('.','..','.gitignore'))) {
                  continue;
                  //  echo "<a href='?dir=$dir'>" . $dir . "</a><hr>";
              }
              //                 $dir = iconv("GBK","UTF-8",$dir);
              $linkDir = $fileDir  . "/" . $dir;
              if(is_dir($dirPath)) {
                  $linkDir = "?dir=" . urlencode($linkDir);
              }else {
                  $linkDir = U( 'Cache/File/view',['file'=>$linkDir]);
              }
              $lastTime = date("Y-m-d H:i:s",fileatime($dirPath));
              echo ' <li> <a href="' . $linkDir .'">
                                            ' . $dir .'
                                            <span>' . $lastTime . '</span></a>
                                        </li>';
          }
      }
      
      public function view () {
          $file = request('file','');
          
          $filePath = storage_path() . $file;
          echo "<pre>" . file_get_contents($filePath) . "</pre>";
      }
}