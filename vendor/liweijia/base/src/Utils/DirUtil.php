<?php

namespace LWJ\Utils;

use Illuminate\Contracts\Filesystem\Filesystem;
use File;

class DirUtil
{

    /**
     * 转化 \ 为 /
     *
     * @param     string    $path    路径
     * @return    string    路径
     */
    public function dirPath($path)
    {
        $path = str_replace(array('\\', '//'), '/', $path);
        if(substr($path, -1) != '/') $path = $path.'/';
        return $path;
    }
    
    /**
     * 创建目录
     *
     * @param     string    $path    路径
     * @param     string    $mode    属性
     * @return    string    如果已经存在则返回true，否则为flase
     */

     public function dirCreate($path, $mode = 0777)
     {
         if(is_dir($path)) return true;
         $path = $this->dirPath($path);
         return File::makeDirectory($path, $mode, true);
    }
    
    
    /**
     * 列出目录下所有文件
     *
     * @param    string    $path        路径
     * @param    string    $exts        扩展名
     * @param    array     $list        增加的文件列表
     * @return   array     所有满足条件的文件
     */

    public function dirList($path, $exts = '', $list= array())
    {
        $path = $this->dirPath($path);
        $files = glob($path.'*');
        foreach($files as $v) {
            if (!$exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
                $list[] = $v;
                if (is_dir($v)) {
                    $list = $this->dirList($v, $exts, $list);
                }
            }
        }
        return $list;
    }
    
    /**
     * 列出目录下所有文件
     * 
     * @param    $path        路径
     * @param    $type        0:所有, 1:目录, 2:文件
     */
    
    public function dirTraverse($path, $type = 0)
    {
        $list = array();
        $path = $this->dirPath($path);
        $files = glob($path.'*');
        foreach($files as $v) {
            if($type == 1){
                if (is_dir($v)) $list[] = $v;
            }elseif ($type == 2){
                if (!is_dir($v)) $list[] = $v;
            }else{
                $list[] = $v;
            }
        }
        return $list;
    }
    
    /**
     * 拷贝目录及下面所有文件
     *
     * @param     string    $fromdir      原路径
     * @param     string    $todir        目标路径
     * @return    string    如果目标路径不存在则返回false，否则为true
     */
    public function dirCopy($fromdir, $todir)
    {
        $fromdir = $this->dirPath($fromdir);
        $todir = $this->dirPath($todir);
        if (!is_dir($fromdir)) return false;
        if (!is_dir($todir)) $this->dirCreate($todir);
        $list = glob($fromdir.'*');
        if (!empty($list)) {
            foreach($list as $v) {
                $path = $todir.basename($v);
                if(is_dir($v)) {
                    $this->dirCopy($v, $path);
                } else {
                    copy($v, $path);
                    chmod($path, 0777);
                }
            }
        }
        return true;
    }
    
    /**
     * 删除目录及目录下面的所有文件
     *
     * @param    $dir        路径
     * @param    $self       是否删除自己本身
     * @return   bool        如果成功则返回 TRUE，失败则返回 FALSE
     */

    public function dirDelete ($dir, $self = true)
    {
        $dir = $this->dirPath($dir);
        if (!is_dir($dir)) return false;
        // 先删除目录下的文件
        $handle = opendir($dir);
        while (($file = readdir($handle)) !== false) {
            if ($file != '.' && $file != '..') {
                $fullpath = trim($dir, '/') . '/' . $file;
                if (!is_dir($fullpath)) {
                    if(file_exists($fullpath)) unlink($fullpath);
                } else {
                    $this->dirDelete($fullpath);
                }
            }
        }
        closedir($handle);
        // 删除当前文件夹
        if($self && count(glob($dir.'*')) == 0){
            return rmdir($dir);
        }
        return true;
    }
    
    
}
