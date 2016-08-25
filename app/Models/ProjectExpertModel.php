<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 项目专家
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-07-09
 *
 */
class ProjectExpertModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'project_expert';
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
                           'territory',
                           'status',
                           'zb_life_weight',
                           'zb_life_score',
                           'zb_life_reason',
                           'zb_risk_weight',
                           'zb_risk_score',
                           'zb_risk_reason',
                           'zb_encourage_weight',
                           'zb_encourage_score',
                           'zb_encourage_reason',
                           'zb_potential_weight',
                           'zb_potential_score',
                           'zb_potential_reason',
                           'zb_gov_weight',
                           'zb_gov_score',
                           'zb_gov_reason',
                           'zb_financing_weight',
                           'zb_financing_score',
                           'zb_financing_reason',
                           'zb_size_weight',
                           'zb_size_score',
                           'zb_size_reason',
                           'zb_expected_weight',
                           'zb_expected_score',
                           'zb_expected_reason',
                           'zb_fixed_weight',
                           'zb_fixed_score',
                           'zb_fixed_reason',
                           'zb_measure_weight',
                           'zb_measure_score',
                           'zb_measure_reason',
                           'zb_growth_weight',
                           'zb_growth_score',
                           'zb_growth_reason',
                           'zb_demonstration_weight',
                           'zb_demonstration_score',
                           'zb_demonstration_reason',
                           'gov_score',
                           'gov_score_desc'
                           ];
                                
}