<?php
/**
 *  
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年12月30日
 *
 */


namespace App\Utils\OSS;


use OSS\OssClient;
use OSS\Core\OssException;
use OSS\Core\OssUtil;

class Alioss{
    
  
    private $_bucket;
    
    private $_oss;
    
    public function __construct($bucket = '')
    {
        if(!$this->_oss) {
            $this->_bucket = $bucket ? $bucket : config("aliyun.oss_bucket");
            $this->_oss  = new OssClient(config('aliyun.access_id'),config('aliyun.access_key'),config('aliyun.oss_endpoint'));
        }
    }
    
    /**
     * 拷贝一个在OSS上已经存在的object成另外一个object
     *
     * @param string $toBucket 目标bucket名称
     * @param string $toObject 目标object名称
     * @param array $options
     * @return null
     * @throws OssException
     */
    public function copyObject($fromObject, $toObject, $options = NULL){
        $this->_oss->copyObject($this->_bucket, $fromObject, $this->_bucket, $toObject, $options);
    }
    
    /**
     * 上传图片到OSS服务器
     * @throws OSS_Exception
     * @param string $ossObj (Required)
     * @param string $img (Required)
     * @param array $httpHeader (Optional)
     * @return array(status, errorMsg)
     */
    public function uploadImg($ossObj, $img)
    {
        $options = array();
        try {
            $res = $this->_oss -> multiuploadFile($this->_bucket, $ossObj, $img, $options);
            return array(SUCESS_CODE,$res);
        }catch (\Exception $e) {
            return array(FAILURE_CODE,$e->getMessage());
        }
    }
    
    
    /**
     * 上传本地目录内的文件或者目录到指定bucket的指定prefix的object中
     *
     * @param string $bucket bucket名称
     * @param string $prefix 需要上传到的object的key前缀，可以理解成bucket中的子目录，结尾不能是'/'，接口中会补充'/'
     * @param string $localDirectory 需要上传的本地目录
     * @param string $exclude 需要排除的目录
     * @param bool $recursive 是否递归的上传localDirectory下的子目录内容
     * @param bool $checkMd5
     * @return array 返回两个列表 array("succeededList" => array("object"), "failedList" => array("object"=>"errorMessage"))
     * @throws OssException
     */
    public function uploadDirTrue($prefix, $localDirectory, $exclude = '.|..|.svn|.git', $recursive = false, $checkMd5 = true)
    {
        $prefix = rtrim($prefix,'/');
        $retArray = array("succeededList" => array(), "failedList" => array());
        if (!is_string($prefix)) throw new OssException("parameter error, prefix is not string");
        if (empty($localDirectory)) throw new OssException("parameter error, localDirectory is empty");
        $directory = str_replace('\\', '/', $localDirectory);
        $directory = OssUtil::encodePath($directory);
        //判断是否目录
        if (!is_dir($directory)) {
            throw new OssException('parameter error: ' . $directory . ' is not a directory, please check it');
        }
        //read directory
        $file_list_array = OssUtil::readDir($directory, $exclude, $recursive);
        if (!$file_list_array) {
            throw new OssException($directory . ' is empty...');
        }
        
        foreach ($file_list_array as $k => $item) {
            if (is_dir($item['path'])) {
                continue;
            }
            $options = array(
                'checkmd5' => $checkMd5,
            );
            $item['file'] = str_replace('\\', '/', $item['file']);
            $item['file'] = str_replace($directory, '', $item['file']);
            $realObject = $prefix  . '/' . $item['file'];
            $realObject = str_replace("\\","/", $realObject);
            $realObject = str_replace("//","/", $realObject);
            
            try {
                $this->_oss->multiuploadFile($this->_bucket, $realObject, $item['path'], $options);
                $retArray["succeededList"][] = $realObject;
            } catch (OssException $e) {
                $retArray["failedList"][$realObject] = $e->getMessage();
            }
        }
        return $retArray;
    }
   
    
    public function __call($func, $param) {
        //执行业务接口
        $param = array_merge([$this->_bucket],$param);
        $result=call_user_func_array(array($this->_oss,$func),$param);
        return $result;
    }
}