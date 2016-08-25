<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 用户表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-06-27
 *
 */
class UserInfoModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'user_info';
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
                           'username',
                           'avater',
                           'email',
                           'password',
                           'remember_token',
                           'mobile',
                           'admin_role_id',
                           'type',
                            'status',
                            'visit_video',
                           'last_login_time'
                           ];

    public function expertInfo() {
        return $this->hasOne('App\Models\UserExpertModel', 'user_id', 'id');
    }
    public function govInfo() {
        return $this->hasOne('App\Models\UserGovModel', 'user_id', 'id');
    }
}