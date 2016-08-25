<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-06-27
 *
 */
class UserExpertModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'user_expert';
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
                           'user_id',
                           'name',
                           'mobile',
                           'avater',
                           'territory',
                           'position',
                           'academy',
                           'education',
                           'project_desc',
                           'resume',
                           'undertaking',
                           'meet_time',
                           'gov_score',
                           'hot'
                           ];

    public function baseUser() {
        return $this->hasOne('App\Models\UserInfoModel', 'id', 'user_id');
    }
}