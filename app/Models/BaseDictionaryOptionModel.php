<?php
namespace App\Models;
use App\Models\BaseModel;
/**
 *  @description 数据字典数据
 *  @author  wangzhoudong  <admin@yijinba.com>;
 *  @version    1.0
 *  @date 2015-10-24
 *
 */
class BaseDictionaryOptionModel extends BaseModel
{
    /**
     * 数据表名
     * 
     * @var string
     *
     */
    protected $table = 'base_dictionary_option';
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
    protected $fillable = ['id','dictionary_table_code','dictionary_code','key','value','name','input_code','sort'];
}