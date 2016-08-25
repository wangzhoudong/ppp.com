<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 后台菜单表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2015-11-13
 *
 */
class AdminMenusModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'admin_menus';
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
    protected $fillable = ['pid','path','name','display','sort','level','mark'];
}