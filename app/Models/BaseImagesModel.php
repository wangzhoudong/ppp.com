<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 图片管理表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2015-10-24
 *
 */
class BaseImagesModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'base_images';
    /**
                主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;
    
    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = ['id','system','system_primary','system_key','url','path','remark'];
    
}