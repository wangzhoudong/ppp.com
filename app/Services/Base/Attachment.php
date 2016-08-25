<?php

namespace App\Services\Base;

use ZipArchive;
use App\Utils\OSS\Alioss;
use App\Utils\DirUtil;

class Attachment
{
    // 定义允许上传的文件扩展名
    protected $ext_arr;
    private $_dirUtil;
    
    public function __construct()
    {
        $this->ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file'  => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        if( !$this->_dirUtil ) $this->_dirUtil = new DirUtil();
    }

    /**
     * flash上传初始化
     * 初始化swfupload上传中需要的参数
     * @param $setting
     * @param $param = [
     *          'position'  =>  '',         图片存储位置，local:本地, ali:阿里云
     *          'folder'    =>  '',         远程文件夹目录
     * ]
     */
    public function initupload($setting = array(), $param = array()){
        //文件大小限制
        $file_size_limit = isset($setting['file_size_limit']) ? $setting['file_size_limit'] : "10 MB";
        $file_upload_limit = isset($setting['file_upload_limit']) ? $setting['file_upload_limit'] : 100;
        
        //允许的附件上传类型
        if(isset($setting['file_types'])){
            $file_types = '*.' . str_replace(array(' ', '|'), array('', '; *.'), $setting['file_types']);
        }else{
            $file_types = '*.jpg; *.jpeg; *.gif; *.png; *.bmp; *.zip; *.rar';
        }
        
        //POST提交参数
        $post_params = '"PHPSESSID" : "' . session()->getId() . '", "elementid" : id, "_token" : "' . csrf_token() . '"';
        if(!empty($param)){
            foreach ($param AS $key => $val){
                $post_params .= ', "' . $key . '" : "' . $val . '"';
            }
        }
  
        $init =  'var swfu = \'\';
    var message_id = \'\';
    function initUploadControl(id, param) {

    	var settings = {
    		flash_url : "/admin-skins/js/swfupload/swfupload.swf",
    		flash9_url : "/admin-skins/js/swfupload/swfupload_fp9.swf",
    		post_params : {' . $post_params . '},
    		upload_url : "' . U('Foundation/Attachment/upload') . '",
    		file_size_limit : "' . $file_size_limit . '",
    		file_types : "' . $file_types . '",
            file_upload_limit:"' . $file_upload_limit . '",
    
    		button_image_url : "/admin-skins/js/swfupload/select-button.png",
    		button_placeholder_id : id,
    		button_width : 65,
    		button_height : 29,
            button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
    
    		swfupload_preload_handler : preLoad,
    		swfupload_load_failed_handler : loadFailed,
            file_dialog_start_handler : fileDialogStart,
    		file_dialog_complete_handler : fileDialogComplete,
            file_queue_error_handler: fileQueueError,
            upload_progress_handler: uploadProgress,
    		upload_error_handler : uploadErrorCo,
    		upload_success_handler : uploadSuccessCo,
    		upload_complete_handler : uploadCompleteCo
    	};
    	if(param) $.extend(settings.post_params, param);
    	swfu = new SWFUpload(settings);
    }';
        $init .= "\r\n".'function uploadErrorCo(data) {
        parent.layer.msg("500, 服务器内部错误", {icon: 2});
    }
    function fileQueueError(file, errorCode, message) {
        if (errorCode == SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
            parent.layer.msg("上传队列中最多只能有3个文件等待上传", {icon: 2});
            return;
        }
        switch (errorCode) {
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                parent.layer.msg("文件大小超出限制", {icon: 2});
                break;
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
                parent.layer.msg("文件类型受限", {icon: 2});
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                parent.layer.msg("文件为空文件", {icon: 2});
                break;
            default:
            	parent.layer.msg("加载入队列出错", {icon: 2});
                break;
        }
    }
    function fileDialogStart(file){
        message_id = this.settings.button_placeholder_id;
    }
    function uploadProgress(file, bytesCompleted, bytesTotal) {
        var percentage = Math.round((bytesCompleted / bytesTotal) * 100);  
        $("#message_" + message_id).html(\'<font color="#449d44">\' + percentage + \'%</font>\');
        if(percentage==100){
            $("#message_" + message_id).html(\'<font color="#449d44">文件保存中...</font>\');
        }
    }'."\r\n";
        return $init;
    }
    

    /**
     * 上传到本地服务器
     * @param $field
     * @param $request
     */
    public function localUpload($field = '', $request = array())
    {
        $uploadfiles = $this->_uploadfiles($field);
        if(!$uploadfiles){
            return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '没有文件被上传']);
        }

        //文件夹路径
        $folder = isset($request['folder']) ? $request['folder'] : 'upload/common';
        $folder = ltrim($folder,'/');
        $fileext = strtolower(trim(substr(strrchr($uploadfiles[0]['name'], '.'), 1, 10)));

        $fileurl = $folder . '/' . md5_file($uploadfiles[0]['tmp_name']) . '.' . $fileext;
        $filePath = public_path() . DIRECTORY_SEPARATOR . $fileurl;
        $dirPath = public_path() . DIRECTORY_SEPARATOR .$folder;
        //创建目录
        if(!is_dir($dirPath)){
            $this->_dirUtil->dirCreate($dirPath);
        }


        //ZIP解压
        if(in_array($fileext,['php','html','js','asp','jsp','shell','bat'])) {
           return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '不允许上传的文件', 'fileurl' => '']);
          }


        if(move_uploaded_file($uploadfiles[0]['tmp_name'],  $filePath)){
            if(in_array($fileext,['jpg','jpeg','gif','bmp','png'])) {
                $img = \Image::make($filePath);
                if(in_array($img->mime(),['image/png','image/jpeg','image/gif','image/bmp'])) {
                    $img->resize(400,null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($filePath . '.middle.jpg');
                }
            }
            $fileurl = '/' .  $fileurl ;
            return $this->_jsonMessage(SUCESS_CODE, $request['elementid'], ['message' => '文件上传成功11', 'fileurl' => $fileurl, 'filename' => basename($uploadfiles[0]['name'])]);
        }else{
            return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '文件上传失败', 'fileurl' => '']);
        }


        if($message['code'] == 200){
            //修改文件夹为只读属性
            chmod($filePath, 0444);
        }else{
            if(file_exists($filePath)){
                rmdir($filePath);
            }
        }
        return $this->_jsonMessage($message['code'], $request['elementid'], ['message' => $message['message'], 'fileurl' => $fileurl, 'filename' => basename($uploadfiles[0]['name'], '.' . $fileext)]);
    }
    
    /**
     * 处理上传文件
     * @param $field
     */
    private function _uploadfiles($field = ''){
        $uploadfiles = array();
        $field = $field ? $field : 'Filedata';
        if(!isset($_FILES[$field])) return $uploadfiles;
        
        if(is_array($_FILES[$field]['error'])) {
            foreach($_FILES[$field]['error'] as $key => $error) {
                if($error === UPLOAD_ERR_NO_FILE) continue;
                if($error !== UPLOAD_ERR_OK) return false;
                $uploadfiles[$key] = array('tmp_name' => $_FILES[$field]['tmp_name'][$key], 'name' => $_FILES[$field]['name'][$key], 'type' => $_FILES[$field]['type'][$key], 'size' => $_FILES[$field]['size'][$key], 'error' => $_FILES[$field]['error'][$key]);
            }
        } else {
            $uploadfiles[0] = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error']);
        }
        return $uploadfiles;
    }
    
    private function _zipTool($fromFile, $toFile) {
        if(!get_extension_funcs('zip')){
            $msg = ['code' => 500, 'message' => '没有发现ZIP扩展库'];
        } else {
            $zip = new ZipArchive();
            if ($zip->open($fromFile) === TRUE) {
                $zip->extractTo($toFile);
                $zip->close();
                $msg = ['code' => 200, 'message' => 'ZIP文件上传，并解压成功'];
            } else {
                $msg = ['code' => 400, 'message' => '不是有效的ZIP文件'];
            }
        }
        return $msg;
    }
    
    private function _rarTool($fromFile, $toFile) {
        if($rarFile = rar_open($fromFile)){
            if($list = rar_list($rarFile)){
                foreach($list as $file) {
                    $pattern = '/\".*\"/';
                    preg_match($pattern, $file, $matches, PREG_OFFSET_CAPTURE);
                    $pathStr = $matches[0][0];
                    $pathStr = str_replace("\"", '', $pathStr);
                    $entry = rar_entry_get($rarFile, $pathStr) or die('entry not found');
                    $entry -> extract($toFile);
                }
                rar_close($rarFile);
                $msg = ['code' => 200, 'message' => 'RAR文件上传，并解压成功'];
            }else{
                $msg = ['code' => 400, 'message' => '压缩包损坏，无法解压'];
            }
        }else{
            $msg = ['code' => 400, 'message' => '不是有效的RAR文件'];
        }
        return $msg;
    }
    
    /**
     * 阿里云附件上传方法
     * @param $field
     * @param $request
     */
    public function aliUpload($field = '', $request = array()) {

        try
        {
            $uploadfiles = $this->_uploadfiles($field);
            if(!$uploadfiles){
                return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '没有文件被上传']);
            }
            //阿里云远程图片服务器
            $folder = isset($request['folder']) ? trim($request['folder'], '/') : 'common';
            $fileext = strtolower(trim(substr(strrchr($uploadfiles[0]['name'], '.'), 1, 10)));

            $bucket = (isset($request['bucket']) && $request['bucket']) ? $request['bucket'] : '';
            $Alioss = new Alioss($bucket);
            $file_type = empty($request['file_type']) ? 'image' : trim($request['file_type']);

            //检查扩展名
            if ($file_type != 'all' && (in_array($fileext, $this->ext_arr[$file_type]) === false)) {
                return $this->_jsonMessage(104, $request['elementid'], ['message' => "上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $this->ext_arr[$file_type]) . "格式。"]);
            }

            if(isset($request['rename']) && $request['rename']){
                //原文件名
                $fileurl = $folder . '/' . $uploadfiles[0]['name'];
            }else{
                //重命名文件名
                $fileurl = $folder . '/' . md5_file($uploadfiles[0]['tmp_name']) . '.' . $fileext;
            }

            //判断图片高宽
            if((isset($request['width']) && $request['width']) || (isset($request['height']) && $request['height'])){
                $imageInfo = getimagesize($uploadfiles[0]['tmp_name']);
                $_msg = "图片宽高要求" . $request['width'] . "x" . $request['height'] . "像素";
                if(isset($imageInfo[0]) && ($request['width'] != $imageInfo[0])){
                    return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => $_msg]);
                }elseif(isset($imageInfo[1]) && ($request['height'] != $imageInfo[1])){
                    return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => $_msg]);
                }
            }

            //执行图片上传
            $res = $Alioss -> uploadImg($fileurl, $uploadfiles[0]['tmp_name']);

            if($res[0] == 200){
                $fileurl = config('sys.sys_images_url') . $fileurl;
                $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '文件上传成功', 'fileurl' => $fileurl]);
            }else{
                $message = $this->_jsonMessage($res[0], $request['elementid'], ['message' => '文件上传失败,云错误代码:'.$res[0]]);
            }
        } catch (\Exception $e) {
            $message['exception'] = '<font color="#d9534f">' . $e->getMessage() . '</font>';
        }

        return $message;
    }


    /**
     * 获取附件名称
     */
    protected function getName(){
        return date('Ymdhis').rand(1000, 9999);
    }


    
    /**
     * JSON消息输出
     * @param $code
     * @param $elementid
     * @param $msg
     * @return Ambigous <string, unknown>
     */
    private function _jsonMessage($code, $elementid, $msg = [])
    {
        $message = $msg;
        $message['code'] = $code;
        if($elementid){
            $message['messageid'] = 'message_' . $elementid;
            $message['successid'] = 'success_' . $elementid;
        }
        if($code == 200){
            $message['message'] = '<font color="#449d44">' . $msg['message'] . '</font>';
        }else{
            $message['message'] = '<font color="#d9534f">' . $msg['message'] . '</font>';
        }
        if(isset($msg['fileurl'])){
            $message['fileurl'] = $msg['fileurl'];
        }
        return $message;
    }

}
