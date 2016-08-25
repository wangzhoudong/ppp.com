<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 项目主表
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2016-07-27
 *
 */
class ProjectInfoModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'project_info';
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
                           'project_nature',
                           'type',
                           'image',
                           'user_id',
                           'name',
                           'place_area_id',
                           'place_province_id',
                           'place_city_id',
                           'place',
                           'financial_situation',
                           'recent_5_year',
                           'item_project',
                           'property',
                           'total_investment',
                           'annual_operating_cost',
                           'annual_operating_income',
                           'operation_pattern',
                           'builder_company',
                           'cooperation_year',
                           'asset_ownership',
                           'current_progress',
                           'financing_proportion',
                           'financing_proportion_zf',
                           'financing_proportion_sh',
                           'financing_proportion_xm',
                           'financing_proportion_xm_count',
                           'project_financial',
                           'reward_mechanism',
                           'profit_estimation',
                           'supporting_plan',
                           'land_acquisition',
                           'operating_taxes',
                           'tax_preference',
                           'social_capital',
                           'financing_loans_desc',
                           'pre_scheme_file',
                           'other_info_file',
                           'counseling_times',
                           'zb_life_weight',
                           'zb_risk_weight',
                           'zb_encourage_weight',
                           'zb_potential_weight',
                           'zb_gov_weight',
                           'zb_financing_weight',
                           'zb_size_weight',
                           'zb_expected_weight',
                           'zb_fixed_weight',
                           'zb_measure_weight',
                           'zb_growth_weight',
                           'zb_demonstration_weight',
                           'status'
                           ];

    public function expertInfo() {
        return $this->hasOne('App\Models\ProjectExpertModel', 'project_id', 'id');
    }

    public function questionInfo() {

    }
}