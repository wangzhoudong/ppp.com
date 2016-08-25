<?php
/**
 *  图片
 *  @author wangzhoudong
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
namespace App\Services\Base;

use App\Services\Base\BaseProcess;
use App\Models\BaseImagesModel;

class Images extends BaseProcess
{
    /**
     * 模型
     */
    private $_model;
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        if( !$this->_model) $this->_model = new BaseImagesModel();
    }

    /**
     * 添加
     * @param $data
     */
    public function create($data)
    {
        return $this->_model->create($data);
    }

    /**
     * 删除
     * @param $id
     */
    public function destroy($system, $system_primary, $system_key = '')
    {
        $currentQuery = $this->_model;
        $currentQuery = $currentQuery->where('system', $system)->where('system_primary', $system_primary);
        if($system_key){
            $currentQuery = $currentQuery->where('system_key', $system_key);
        }
        return $currentQuery->delete();
    }
    
    public function getImages($system, $system_primary, $system_key = NULL)
    {
        $currentQuery = $this->_model;
        if($system_key){
            $currentQuery = $currentQuery->where('system_key', $system_key);
        }
        return $currentQuery->where('system', $system)->where('system_primary', $system_primary)->get();
    }
    
    /**
     * 查询多条数据
     */
    public static function get($system, $system_primary = NULL, $system_key = NULL, $first = false, $pagesize = PAGE_MAX_NUMS){
        
        $currentQuery = new BaseImagesModel();
        $currentQuery = $currentQuery->where('system', $system);
        
        if($system_primary){
            $currentQuery = $currentQuery->where('system_primary', $system_primary);
        }
        
        if($system_key){
            $currentQuery = $currentQuery->where('system_key', $system_key);
        }
        
        if($first){
            return $currentQuery->first();
        }else{
            return $currentQuery->take($pagesize)->get();
        }
    }
    
    /**
     * 获取图片src
     */
    public static function getSrc($system, $system_primary = NULL, $system_key = NULL, $first = false, $pagesize = PAGE_MAX_NUMS)
    {
        $obj = self::get($system, $system_primary, $system_key, $first, $pagesize);
        
        if($first){
            return isset($obj->url) ? $obj->url : '';
        }else{
            $array = [];
            foreach ($obj AS $img){
                $array[] = isset($img->url) ? $img->url : '';
            }
            return $array;
        }
    }
    
}
