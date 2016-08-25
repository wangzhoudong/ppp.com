<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 后台操作日志
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-06-25
 *
 */
class LogAdminOperateModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'log_admin_operate';
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
                           'user_id',
                           'operator',
                           'url',
                           'method',
                           'request_data',
                           'md5'
                           ];
                                
}