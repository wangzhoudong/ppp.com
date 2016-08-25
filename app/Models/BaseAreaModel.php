<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 区域表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-06-21
 *
 */
class BaseAreaModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'base_area';
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
    protected $fillable = [
                           'name',
                           'pid',
                           'short_name',
                           'grade',
                           'city_code',
                           'zip_code',
                           'merger_name',
                           'lng',
                           'lat',
                           'pinyin'
                           ];
                                
}