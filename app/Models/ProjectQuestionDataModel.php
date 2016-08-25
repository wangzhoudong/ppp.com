<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 问题回答
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-07-04
 *
 */
class ProjectQuestionDataModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'project_question_data';
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
                           'project_question_id',
                           'user_id',
                           'nickname',
                           'content'
                           ];
    public function baseUser() {
        return $this->hasOne('App\Models\UserInfoModel', 'id', 'user_id');
    }
}