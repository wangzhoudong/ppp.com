<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description ＰＰＰ项目风险评价表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-07-27
 *
 */
class ProjectRiskModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'project_risk';
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
                           'type',
                           'title',
                           'desc',
                           'stage',
                           'baseline',
                           'benchmark'
                           ];
                                
}