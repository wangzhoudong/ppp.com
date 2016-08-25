<?php
/**
 *  图片
 *  @author  wangzhoudong@liweijia.com
 *  @version    1.0
 *  @date 2015年10月9日
 *
 */
namespace LWJ\Services\Base;

use LWJ\Services\Base\BaseProcess;
use App\Models\BaseAreaModel;

class BaseArea extends BaseProcess
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
