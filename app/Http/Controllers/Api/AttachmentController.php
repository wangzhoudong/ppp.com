<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Api\Controller;
use App\Services\Base\Attachment;
use App\Utils\DirUtil;
use App\Services\Base\AttachmentBbs;

class AttachmentController extends Controller
{
    private $_dirUtil;
    private $_serviceAttachment;
    private $_serviceAttachmentBbs;

    function __construct()
    {
        if( !$this->_dirUtil ) $this->_dirUtil = new DirUtil();
        if( !$this->_serviceAttachment ) $this->_serviceAttachment = new Attachment();
    }

    /**
     * 百度上传
     */
    public function webupload(Request $request)
    {

        $request = $request->all();
        $data = $this->_serviceAttachment->localUpload('file', $request);
        echo json_encode($data);exit;
    }


    /**
     * 头像上传
     */
    public function avatarUpload(Request $request)
    {
        if(!isset($_FILES['file'])){
            $message['code'] = FAILURE_CODE;
            $message['message'] = '没有文件被上传！';
            echo json_encode($message); exit;
        }
        $fileext = fileExt($_FILES['file']['name']);

        $avatar_name = 'avatar_' . $request->get('user_id') . '.' . $fileext;
        //定义头像临时文件夹
        $avatar_dir = base_path('public').'/temp/avatar/';
        if(!file_exists($avatar_dir)){
            $this->_dirUtil->dirCreate($avatar_dir);
        }
        //图片路径
        $avatar_path = $avatar_dir . $avatar_name;
        $avatar_url = 'http://' . config('sys.sys_www_domain') . '/temp/avatar/' . $avatar_name;
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $avatar_path)){
            $size_src = getimagesize($avatar_path);
            if($size_src['0'] < 200 || $size_src['1'] < 200){
                unlink($avatar_path);
                $message['code'] = FAILURE_CODE;
                $message['message'] = '头像图片高宽不能小于200像素！';
            }else{
                $message['code'] = SUCESS_CODE;
                $message['fileurl'] = $avatar_url;
            }
        }else{
            $message['code'] = FAILURE_CODE;
            $message['fileurl'] = '';
        }
        echo json_encode($message); exit;
    }
    


}
