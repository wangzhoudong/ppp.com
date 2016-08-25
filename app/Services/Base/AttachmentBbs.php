<?php

namespace App\Services\Base;

use App\Utils\OSS\Alioss;
use Request;
use App\Models\Bbs\PreForumAttachmentModel;
use App\Models\Bbs\PreForumAttachmentUnusedModel;
 
class AttachmentBbs
{

    private $_alioss;
    private $_extArr;
    private $_imageUrl;
    private $_directory;
    
    public function __construct()
    {
        $this->_extArr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file'  => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        if( !$this->_alioss ) $this->_alioss = new Alioss();
        if( !$this->_imageUrl ) $this->_imageUrl = config('sys.sys_images_url');
        if( !$this->_directory ) $this->_directory = 'upload/family/attachment/';
    }
    
    
    public function getSubDir(){
        $subdir1 = date('Ym');
        $subdir2 = date('d');
        $subdir = $subdir1.'/'.$subdir2.'/';
        
        return $subdir;
    }
    
    public function crop($img, $data) {
        $message = array();
        $message['code'] = SUCESS_CODE;
        $message['message'] = '成功！';
        
        $jpeg_quality = 100;
        $src = $img['target'];
    
        //判断文件是否存在
        if(!file_exists($src)){
            $message['code'] = FAILURE_CODE;
            $message['message'] = '图片文件不存在！';
            return $message;
        };
    
        //取得源图片的宽度和高度
        $size_src = @getimagesize($src);
    
        $_temp_name = str_replace($img['attachdir'], '', $img['attachment']);
    
        //图片临时路径
        $avatar_name = substr($_temp_name, 0, strpos($_temp_name, '.')).'_temp';
        $avatar_name2 = substr($_temp_name, 0, strpos($_temp_name, '.'));
    
        $avatar_dir = base_path('public').$img['attachdir'];
    
        $avatar_path = $avatar_dir . $avatar_name . '.jpg';
        $avatar_path2 = $avatar_dir . $avatar_name2 . '.jpg';
        
        //将所有图片转换为JPG
        $img_jpg = imagecreatefromstring(file_get_contents($src));
        if(imagejpeg($img_jpg, $avatar_path, $jpeg_quality)){
            if($img['ext'] != 'jpg'){
                @unlink($avatar_dir . $avatar_name2 . '.' .$img['ext']);
            }
            imagedestroy($img_jpg);
        }
    
        $w_scale = $size_src[0] / $data['sw'];
        $h_scale = $size_src[1] / $data['sh'];
    
        $targ_w = $w_scale * $data['w'];
        $targ_h = $h_scale * $data['h'];
    
        $img_r = imagecreatefromstring(file_get_contents($avatar_path));
        $dst_r = imagecreatetruecolor($targ_w , $targ_h);
    
        //裁剪
        imagecopy($dst_r, $img_r, 0, 0, $data['x'] * $w_scale, $data['y'] * $h_scale,$size_src[0],$size_src[1]);
    
        if(imagejpeg($dst_r, $avatar_path2, $jpeg_quality)){
            @unlink($avatar_dir . $avatar_name . '.jpg');
            imagedestroy($dst_r);
        }
        
        $imginfo = getimagesize($avatar_path2);
        $width = $imginfo[0];
        $height = $imginfo[1];
        $type = $imginfo[2];
        $attr = $imginfo[3];
        $bits = $imginfo['bits'];
        $channels = $imginfo['channels'];
        $mime = $imginfo['mime'];
        
        $size = filesize($avatar_path2);
    
        $message['imageinfo'] = array(
                'fileurl'=> $avatar_path2,
                'thumb'=> $img['thumb'],
                'attachment'=> $img['attachdir'].$avatar_name2.'.jpg',
                'name'=> $img['name'],
                'attachdir'=> $img['attachdir'],
                'target'=> base_path('public') . $img['attachdir'] . $avatar_name2 . '.jpg',
                'isimage'=> $this->isImageExt('jpg'),
                'ext'=>'jpg',
                'size'=>$size,
                'width'=>$width,
                'height'=>$height,
                'type'=>$type,
                'attr'=>$attr,
                'bits'=>$bits,
                'channels'=>$channels,
                'mime'=>$mime,
        );
    
        return $message;
    }
    
    /**
     * 上传到阿里云oss
     */
    public function uploadOss($uid, $img, $data){
        //阿里云路径
        $avatar_ali_path = $this->_directory.'forum/' . $this->getSubDir(). $img['name'];
        $avatar_url = $this->_imageUrl . $avatar_ali_path;
    
        //执行图片上传
        $res = $this->_alioss -> uploadImg($avatar_ali_path, $img['target']);
    
        if($res[0] == 200){
            $aid = (new PreForumAttachmentModel())->create(array('tid' => 0, 'pid' => 0, 'uid' => $uid, 'tableid' => 127));
            
            $insert = array(
                    'aid' => $aid->aid,
                    'dateline' => SYSTEM_TIME,
                    'filename' => dhtmlspecialchars($img['name']),
                    'filesize' => $img['size'],
                    'attachment' => $this->getSubDir(). $img['name'],
                    'isimage' => $img['isimage'],
                    'uid' => $uid,
                    'thumb' => $img['thumb'],
                    'remote' => 1,
                    'width' => $img['width'],
            );
            (new PreForumAttachmentUnusedModel())->create($insert);
    
            $message['code'] = SUCESS_CODE;
            $message['message'] = '上传成功！';
    
            $message['aid'] = $aid->aid;
            $message['url'] = $avatar_url;
            $message['attachment'] =  $this->getSubDir(). $img['name'];
        }else{
            $message['code'] = FAILURE_CODE;
            $message['message'] = '阿里云上传失败！';
        }
        return $message;
    }
    
    
    
    public function uploadAlioss(){

        try
        {
            //原文件名     $file->getClientOriginalName()
            //临时文件名    $file->getFileName()
            //临时文件路径  $file->getRealPath()
            //原文件扩展    $file->getClientOriginalExtension()

            $file = Request::file('file');
            //项目目录
            $folder = (isset($request['folder']) && $request['folder']) ? trim($request['folder']) : 'forum';
            $attachment = $this->_getName($file->getClientOriginalExtension(), $file->getRealPath());
            $filePath = $this->_directory . $folder . '/' . $attachment;
            //获取文件信息
            $fileSize = filesize($file->getRealPath());
            if(in_array($file->getClientOriginalExtension(), $this->_extArr['image'])){
                $imgInfo = getimagesize($file->getRealPath());
            }

            //执行上传
            $res = $this->_alioss->uploadImg($filePath, $file->getRealPath());

            if($res[0] == 200){
                $fileurl = $this->_imageUrl . $filePath;
                $info = [
                    'message' => '文件上传成功',
                    'fileurl' => $fileurl,
                    'filesize' => $fileSize,
                    'filename' => $file->getClientOriginalName(),
                    'attachment' => $attachment,
                    'width' => isset($imgInfo[0]) ? $imgInfo[0] : 0,
                ];
                $message = $this->_jsonMessage(SUCESS_CODE, $info);
            }else{
                $message = $this->_jsonMessage(FAILURE_CODE, ['message' => '文件上传失败,云错误代码:'.$res[0]]);
            }
        } catch (\Exception $e) {
            $message['message'] = '<font color="#d9534f">' . $e->getMessage() . '</font>';
        }

        return $message;

    }

    /**
     * 获取名称
     */
    private function _getName($ext, $realPath = ''){
        //return date('Ym') . '/' . date('d') . '/' . date('His') . str_random() . '.' . $ext;
        return date('Ym') . '/' . date('d') . '/' . md5_file($realPath) . '.' . $ext;
    }

    /**
     * JSON消息输出
     * @param $code
     * @param $elementid
     * @param $msg
     * @return Ambigous <string, unknown>
     */
    private function _jsonMessage($code, $data = [])
    {
        $message['code'] = $code;
        if($code == SUCESS_CODE){
            $message['message'] = '<font color="#449d44">' . $data['message'] . '</font>';
        }else{
            $message['message'] = '<font color="#d9534f">' . $data['message'] . '</font>';
        }
        unset($data['message']);
        $message['data'] = $data;

        return $message;
    }
    
    
    public function isImageExt($ext) {
        static $imgext  = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
        return in_array($ext, $imgext) ? 1 : 0;
    }
    
    public function getImageInfo($target, $allowswf = false) {
        $ext = fileExt($target);
        $isimage = $this->isImageExt($ext);
        if(!$isimage && ($ext != 'swf' || !$allowswf)) {
            return false;
        } elseif(!is_readable($target)) {
            return false;
        } elseif($imageinfo = @getimagesize($target)) {
            list($width, $height, $type) = !empty($imageinfo) ? $imageinfo : array('', '', '');
            $size = $width * $height;
            if($size > 18915904 || $size < 16 ) {
                return false;
            } elseif($ext == 'swf' && $type != 4 && $type != 13) {
                return false;
            } elseif($isimage && !in_array($type, array(1,2,3,6,13))) {
                return false;
            } elseif(!$allowswf && ($ext == 'swf' || $type == 4 || $type == 13)) {
                return false;
            }
            return $imageinfo;
        } else {
            return false;
        }
    }
    
}
