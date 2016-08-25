<?php
/**
 *  模型基类
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月21日
 *
 */
namespace LWJ\Models;

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
    

   
}