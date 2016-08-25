<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 项目->讨论区
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-07-04
 *
 */
class ProjectQuestionModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'project_question';
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
                           'project_id',
                           'user_id',
                           'title',
                           'count'
                           ];

    public function dataInfo() {
        return $this->hasMany('App\Models\ProjectQuestionDataModel', 'project_question_id', 'id');
    }
}