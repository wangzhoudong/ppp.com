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
use App\Models\BaseAreaModel;
use App\Models\ShopStoreModel;

class BaseArea extends BaseProcess
{
    /**
     * 模型
     *
     * @var object
     * 
     */
    private $objModel;
    private $_shopStoreModel;
    
    private $groupModel;
    
    private $userInfo;
    
    //自治区---门店直接绑定自治区，不会绑定到下一级区域
    public $municipality;
    
    
    /**
     * 初始化
     *
     * @access public
     * 
     */
    public function __construct()
    {
        if( ! $this->objModel) $this->objModel = new BaseAreaModel();
        if( ! $this->_shopStoreModel) $this->_shopStoreModel = new ShopStoreModel();
        if( ! $this->municipality){
            $this->municipality = array_keys(dict()->get('global', 'area_autonomous'));
        }
    }
    
    public function model()
    {
        return $this->objModel;
    }
    
    public function getLevel($level=3) {
     
            return $this->objModel
            ->select('id','pid','name','grade')
            ->where("grade","<=",$level)
            ->get()
            ->toArray();
        
    }
    
    
    /**
     * 查询数据
     */
    public function getByPid($pid)
    {
        
        return $this->objModel->select('id','pid','name','grade')->where("pid",$pid)->orderBy('id', 'desc')->get()->toArray();
        
    }
    
    /**
     * 获取至少有一个开通门店的省份
     */
    public function getUseByPid($pid)
    {
        $area_ids = [];
        $areas = $this->_shopStoreModel->select('area_id')->get();
        foreach ($areas as $value){
            $area_ids[] = $value->area_id;
        }
        
        $areas = $this->objModel->whereIn('id', $area_ids)->get()->toArray();
        $area_ids = [];
        foreach ($areas as $value){
            if($value['pid'] == 100000){
                $area_ids[] = $value['id'];
            }else{
                $area_ids[] = $value['pid'];
            }
        }
        
        return $this->objModel->where('pid', '=', $pid)->where(function($query) use($area_ids){
            $query->whereIn('id', $area_ids)->orWhereIn('pid', $area_ids);
        })->get()->toArray();
    }
    
    
    
    /**
     * 根据地域ID取得上级信息
     * @param unknown $areaid
     */
    public function getByAreaId($areaid)
    {
        $pinfo = $this->objModel->select('pid')->where("id",intval($areaid))->first();
        if($pinfo->pid == 100000){
            return $areaid;
        }
        return $this->objModel->where("id",intval($pinfo->pid))->first()->id;
    }
    
    
    
}
