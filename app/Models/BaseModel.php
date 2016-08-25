<?php
/**
 *  模型基类
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月21日
 *
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    
    public $timestamps = true;
    
    use SoftDeletes;
    
    /**
     * 多个where 
     * @param Object $query
     * @param array $arr
     *      ['status'=>1, 'name' => '啦啦啦']
     * @return Object $query
     */
    public function multiwhere($query, $arr)
    {
        if (!is_array($arr)) {
            return $query;
        }
        foreach ($arr as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query;
    }


    public function insertForTime(array $values)
    {
        if (empty($values)) {
            return true;
        }

        if (! is_array(reset($values))) {
            $values = [$values];
        } else {
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        foreach($values as &$value){
            $value['created_at'] = date('Y-m-d H:i:s', SYSTEM_TIME);
            $value['updated_at'] = date('Y-m-d H:i:s', SYSTEM_TIME);
        }

        return parent::insert($values);
    }

   
}