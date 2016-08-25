<?php

namespace LWJ\Services\Base;

use ZipArchive;
use LWJ\Utils\OSS\Alioss;
use LWJ\Utils\DirUtil;

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
    function initUploadControl(id) {
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
     * 专题文件上传
     * @param $field
     * @param $request
     */
    public function specialUpload($field = '', $request = array())
    {
        $uploadfiles = $this->_uploadfiles($field);
        if(!$uploadfiles){
            return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '没有文件被上传']);
        }

        //定义专题文件夹名
        $dirname = strtolower(trim(substr($uploadfiles[0]['name'], 0, strrpos($uploadfiles[0]['name'], '.'))));
        //临时路径
        $special_path = base_path('public') . '/temp/special/';
        //创建目录
        if(!file_exists($special_path)){
            $this->_dirUtil->dirCreate($special_path);
        }
        
        //专题文件
        $special_filepath = $special_path . $dirname. '.html';
        
        //获取专题内容
        $special_content = $this->_specialHtml(file_get_contents($uploadfiles[0]['tmp_name']), $request);

        if(file_put_contents($special_filepath, $special_content)){
            $fileurl = 'http://' . config('sys.sys_www_domain') . '/at/' . $dirname . '.html';
            $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '专题文件上传成功', 'special_name' => $dirname ,'fileurl' => $fileurl]);
        }else{
            $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '专题文件上传失败']);
        }
        
        if($message['code'] != 200 && file_exists($special_path)){
            rmdir($special_path);
        }
        return $message;
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
        $folder = isset($request['folder']) ? $request['folder'] : 'common';
        $fileurl = $folder . '/' . date('Ymd', time()) . '_' . md5_file($uploadfiles[0]['tmp_name']);
        $filePath = public_path() . DIRECTORY_SEPARATOR . $fileurl;
        
        //创建目录
        if(!file_exists($filePath)){
            $this->_dirUtil->dirCreate($filePath);
        }

        //获取文件后缀名
        $fileext = strtolower(trim(substr(strrchr($uploadfiles[0]['name'], '.'), 1, 10)));
        
        //ZIP解压
        if($fileext == 'zip'){
            $message = $this->_zipTool($uploadfiles[0]['tmp_name'], $filePath);
        }
        
        //RAR解压
        if($fileext == 'rar'){
            if(!get_extension_funcs('rar')){
                return $this->_jsonMessage(500, $request['elementid'], ['message' => '没有发现RAR扩展库']);
            }else{
                $message = $this->_rarTool($uploadfiles[0]['tmp_name'], $filePath);
            }
        }
        
        if($message['code'] == 200){
            //修改文件夹为只读属性
            chmod($filePath, 0444);
        }else{
            if(file_exists($filePath)){
                rmdir($filePath);
            }
        }
        return $this->_jsonMessage($message['code'], $request['elementid'], ['message' => $message['message'], 'fileurl' => $fileurl]);
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

            //执行图片上传
            $res = $Alioss -> uploadImg($fileurl, $uploadfiles[0]['tmp_name']);

            if($res[0] == 200){
                $fileurl = config('sys.sys_images_url') . $fileurl;
                $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '文件上传成功', 'fileurl' => $fileurl]);
            }else{
                $message = $this->_jsonMessage($res[0], $request['elementid'], ['message' => '文件上传失败,云错误代码:'.$res[0]]);
            }
            //$request['renames'];
        } catch (\Exception $e) {
            $message['exception'] = '<font color="#d9534f">' . $e->getMessage() . '</font>';
        }

        return $message;
    }
    
    /**
     * WEB端模板文件上传
     * @param $field
     * @param $request
     */
    public function webTemplateUpload($field = '', $request = array()) {

        try 
        {
            $uploadfiles = $this->_uploadfiles($field);
            if(!$uploadfiles){
                return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '没有文件被上传']);
            }
            
            //样式文件
            if($request['elementid'] == 'upload_template_web_style'){
                
                $info = $this->_templateStyleHandle($uploadfiles[0], 'web');
                $message = $this->_jsonMessage($info['code'], $request['elementid'], $info);
                
            }elseif($request['elementid'] == 'upload_template_web_detail'){
                
                $fileurl = $this->_templateFileHandle($uploadfiles[0]['tmp_name'], 'web', 'detail');
                if($fileurl){
                    $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '商品详情页上传成功', 'fileurl' => $fileurl]);
                }else{
                    $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '商品详情页上传失败', 'fileurl' => '']);
                }
                
            }elseif($request['elementid'] == 'upload_template_web_material'){
                
                $fileurl = $this->_templateFileHandle($uploadfiles[0]['tmp_name'], 'web', 'material');
                if($fileurl){
                    $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '商品材质页上传成功', 'fileurl' => $fileurl]);
                }else{
                    $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '商品材质页上传失败', 'fileurl' => '']);
                }
                
            }elseif($request['elementid'] == 'upload_template_web_param'){
                
                $fileurl = $this->_templateFileHandle($uploadfiles[0]['tmp_name'], 'web', 'param');
                if($fileurl){
                    $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '商品参数页上传成功', 'fileurl' => $fileurl]);
                }else{
                    $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '商品参数页上传失败', 'fileurl' => '']);
                }
            }            
            
        } catch (\Exception $e) {
            $message['exception'] = '<font color="#d9534f">' . $e->getMessage() . '</font>';
        }
        
        return $message;
    }
    
    /**
     * WAP端模板文件上传
     * @param $field
     * @param $request
     */
    public function wapTemplateUpload($field = '', $request = array()) {
    
        try
        {
            $uploadfiles = $this->_uploadfiles($field);
            if(!$uploadfiles){
                return $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '没有文件被上传']);
            }
    
            //样式文件
            if($request['elementid'] == 'upload_template_wap_style'){
    
                $info = $this->_templateStyleHandle($uploadfiles[0], 'wap');
                $message = $this->_jsonMessage($info['code'], $request['elementid'], $info);
    
            }elseif($request['elementid'] == 'upload_template_wap_detail'){
    
                $fileurl = $this->_templateFileHandle($uploadfiles[0]['tmp_name'], 'wap', 'detail');
                if($fileurl){
                    $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '商品详情页上传成功', 'fileurl' => $fileurl]);
                }else{
                    $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '商品详情页上传失败', 'fileurl' => '']);
                }
    
            }elseif($request['elementid'] == 'upload_template_wap_material'){
    
                $fileurl = $this->_templateFileHandle($uploadfiles[0]['tmp_name'], 'wap', 'material');
                if($fileurl){
                    $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '商品材质页上传成功', 'fileurl' => $fileurl]);
                }else{
                    $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '商品材质页上传失败', 'fileurl' => '']);
                }
    
            }elseif($request['elementid'] == 'upload_template_wap_param'){
    
                $fileurl = $this->_templateFileHandle($uploadfiles[0]['tmp_name'], 'wap', 'param');
                if($fileurl){
                    $message = $this->_jsonMessage(200, $request['elementid'], ['message' => '商品参数页上传成功', 'fileurl' => $fileurl]);
                }else{
                    $message = $this->_jsonMessage(FAILURE_CODE, $request['elementid'], ['message' => '商品参数页上传失败', 'fileurl' => '']);
                }
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
     * 模板文件处理
     * @param $content
     * @param $param
     */
    private function _templateFileHandle($uploadFile, $type, $category, $cache_dir = '/temp/template/')
    {
        $dirPath = public_path() . $cache_dir . $type . '/';
        $fileurl = $category .'_' . md5_file($uploadFile) . '.html';
        
        if(!file_exists($dirPath)){
            $this->_dirUtil->dirCreate($dirPath);
        }
        
        if($type == 'wap'){
            $content = $this->_wapTemplateHtml(file_get_contents($uploadFile));
            if(!file_put_contents($dirPath.$fileurl, $content)){
                $fileurl = '';
            }
        }else{
            $content = $this->_webTemplateHtml(file_get_contents($uploadFile));
            if(!file_put_contents($dirPath.$fileurl, $content)){
                $fileurl = '';
            }
        }
        
        return $fileurl;
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
