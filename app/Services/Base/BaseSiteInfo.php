<?php
/**
 *  图片
 *  @author  wangzhoudong@liweijia.com
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
namespace App\Services\Base;

use App\Services\Base\BaseProcess;
use App\Models\BaseSiteInfoModel;

class BaseSiteInfo extends BaseProcess
{
    /**
     * 模型
     *
     * @var object
     * 
     */
    private $objModel;
    
    private $groupModel;
    
    private $userInfo;
    
    
    /**
     * 初始化
     *
     * @access public
     * 
     */
    public function __construct()
    {
        if( ! $this->objModel) $this->objModel = new BaseSiteInfoModel();
    }
    
    public function model()
    {
        return $this->objModel;
    }
    
    
    /**
     * 查询数据
     */
    public function get()
    {
        return $this->objModel->orderBy('id', 'asc')->get();
    }
    
    /**
     * 根据拼音维度查询数据
     */
    public function getOrderPinyinSort() {
        $allSite =  $this->objModel->orderBy("pinyin_sort","asc")->orderBy('id','asc')->get();
        $pinyinSite = array();
        foreach ($allSite as $key=>$val) {
            $pinyinSite[$val['pinyin_sort']][] = $val;
        }
        return $pinyinSite;
        
    }
    
    /**
     * 获取热门城市
     */
    public function getHot() {
        return $this->objModel->where("is_hot",1)->orderBy('pinyin_sort', 'asc')->get();
    }
    /**
     * 大区维度
     */
    public function regionData() {
        $data =  $this->objModel->select("id","site_name","region_id")->orderBy('region_id', 'asc')->where('region_id', '>',0)->orderBy("id","asc")->get()->toArray();
        $region = array();
        foreach ($data as $val) {
            $region[$val['region_id']][] = $val;
            
        }
        return $region;
    }
    
    public function find($id) {
        
        return $this->objModel->find($id);
    }
    
    /**
     * 模糊匹配城市
     * @param unknown $areaName
     */
    public function getLikeCity($areaName) {
        if(substr($areaName, -3)=='市') {
            $areaName = substr($areaName, 0,-3);
        }
        $data = $this->objModel->where('site_name','like',$areaName)->first();
        if($data) {
           $data =  $data->toArray();
        }
        return $data;
    }
    
}
