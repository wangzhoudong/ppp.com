<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-03-07
 *
 */
class ModulePageParamsModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'module_page_params';
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
                           'platform',
                           'page',
                           'key',
                           'name',
                           'content'
                           ];
                                
}