<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 政府用户
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-06-27
 *
 */
class UserGovModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'user_gov';
    /**
                主键
     */
    protected $primaryKey = 'user_id';

    //分页
    protected $perPage = PAGE_NUMS;
    
    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
                           'project_name',
                           'department',
                           'linkman_tel',
                            'linkman_email',
                           'linkman',
                           'linkman_mobile',
                            'other_info',
                            'pre_scheme',
                           'approve_pic'
                           ];
    public function baseUser() {
        return $this->hasOne('App\Models\UserInfoModel', 'id', 'user_id');
    }
}