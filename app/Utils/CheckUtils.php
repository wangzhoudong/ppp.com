<?php
namespace App\Utils;;
/**
 *  @desc    公共验证工具
 *  @author  wangzd
 */
class CheckUtils
{

    /**
     * @description 检验请求参数有效性
     * @param array $params {
     * 				$key,$val,$require=>true|false,
     * 				$type=>mobile|url|email|chinese|postcode|ido|ip|invalid|length|range,
     * 				$min=>0,$max=>10,$msg
     * 			}
     */
   public static function checkParams(array $params)
    {
        $msg = array();
        foreach ($params as $param) {
            // 必填项
            if (isset($param['require']) && $param['require'] === true && !self::isMust($param['val'])) {
                $msg[] = isset($param['msg']) ? $param['msg'] : $param['key'] . '为必填项';
                continue;
            }
            	
            // 数据类型校验
            $ret = true;
            if(!self::isMust($param['val'])) {
                continue;
            } 
            if (isset($param['type'])) {
                switch ($param['type']) {
                    case 'int':#正负整数
                        $ret = self::isInteger($param['val']);
                        break;
                    case 'pint':#正整数
                        $ret = self::isPosInt($param['val']);
                        break;
                    case 'nint':#负整数
                        $ret = self::isNegInt($param['val']);
                        break;
                    case 'float':#浮点数[整数不通过]
                        $ret = self::isFloat($param['val']);
                        break;
                    case 'number':#数字，整数及浮点数
                        $ret = is_numeric($param['val']);
                        break;
                    case 'pnumber':#数字，整数及浮点数==正数
                        $ret = is_numeric($param['val']);
                        $ret = $ret ? ($param['val']>=0 ? true : false) : false;
                        break;
                    case 'mobile':
                        $ret = self::isMobile($param['val']);
                        break;
                    case 'url':
                        $ret = self::isUrl($param['val']);
                        break;
                    case 'email':
                        $ret = self::isEmail($param['val']);
                        break;
                    case 'chinese':
                        $ret = self::isChineseCharacter($param['val']);
                        break;
                    case 'zip':
                        $ret = self::isPostNum($param['val']);
                        break;
                    case 'ido':
                        $ret = self::isPersonalCard($param['val']);
                        break;
                    case 'ip':
                        $ret = self::isIp($param['val']);
                        break;
                    case 'length':
                        $ret = self::isLength($param['val'], $param['min'], $param['max']);
                        break;
                    case 'value':
                        $ret = self::isValue($param['val'], $param['min'], $param['max']);
                        break;
                    case 'range':
                        if (!isset($param['arr']) || empty($param['arr']) || !in_array($param['val'], $param['arr'])) {
                            $ret = false;
                        }
                        break;
                    case 'date':
                        $ret = self::isDate($param['val']);
                        break;
                    case 'datetime':
                        $ret = self::isDateTime($param['val']);
                        break;
                    case 'empty':
                        $ret = !empty($param['val']);
                        break;
                    default:
                        $ret = !self::isInvalidStr($param['val']);
                        break;
                }
    
                if (!$ret) {
                    if ($param['type'] == 'length' && (isset($param['min']) || isset($param['max']))) {
                        if(isset($param['msg'])) {
                            $msg[] = $param['msg'];
                        } else {
                            if ($param['min'] == $param['max']) {
                                $msg[] = $param['key'] . "长度是{$param['min']}位";
                            } elseif ($param['min'] == 0) {
                                $msg[] = $param['key'] . "长度最大：{$param['max']}";
                            } elseif ($param['max'] == 0) {
                                $msg[] = $param['key'] . "长度最小：{$param['min']}";
                            }
                            
                        }
                    } else if ($param['type'] == 'value' && (isset($param['min']) || isset($param['max']))) {
                        if(isset($param['msg'])) {
                            $msg[] = $param['msg'];
                        } else {
                            if ($param['min'] == $param['max']) {
                                $msg[] = $param['key'] . "值必须是：{$param['min']}";
                            } elseif ($param['min'] == 0) {
                                $msg[] = $param['key'] . "值最大只能是：{$param['max']}";
                            } elseif ($param['max'] == 0) {
                                $msg[] = $param['key'] . "值最小只能是：{$param['min']}";
                            }
                            
                        }
                    } else {
                        $msg[] = (isset($param['msg']) ? $param['msg'] : $param['key']) . '格式错误';
                    }
                }
                // === msg end === //
            }
        }
        return $msg;
    }
    
    /**
     * 整数（正负数）
     */
    public static function isInteger($str)
    {
        return preg_match('/^(\-)?[0-9]+$/',$str) ? true : false;
    }
    
    /**
     * 正整数
     */
    public static function isPosInt($str)
    {
        return preg_match('/^[0-9]+$/',$str) ? true : false;
    }
    
    /**
     * 负整数
     */
    public static function isNegInt($str)
    {
        return preg_match('/^\-[0-9]+$/',$str) ? true : false;
    }
    
    /**
     * 浮点数
     */
    public static function isFloat($str)
    {
        return preg_match('/^[0-9]+\.[0-9]+$/',$str) ? true : false;
    }
    
	/**
	 * 正则表达式验证email格式
	 *
	 * @param string $str    所要验证的邮箱地址
	 * @return boolean
	 */
	public static function isEmail($str)
	{
		if (!$str) {
			return false;
		}
		return preg_match('#[a-z0-9&\-_.]+@[\w\-_]+([\w\-.]+)?\.[\w\-]+#is', $str) ? true : false;
	}

	/**
	 * 正则表达式验证网址
	 *
	 * @param string $str    所要验证的网址
	 * @return boolean
	 */
	public static function isUrl($str)
	{
		if (!$str) {
			return false;
		}
		return preg_match('/^http(s)?://([a-zA-Z0-9\.]?([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5})|((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9]))/', $str) ? true : false;
	}

	/**
	 * 验证字符串中是否含有汉字
	 *
	 * @param integer $string    所要验证的字符串。注：字符串编码仅支持UTF-8
	 * @return boolean
	 */
	public static function isChineseCharacter($string)
	{
		if (!$string) {
			return false;
		}
		return preg_match('~[\x{4e00}-\x{9fa5}]+~u', $string) ? true : false;
	}

	/**
	 * 验证字符串中是否含有非法字符
	 *
	 * @param string $string    待验证的字符串
	 * @return boolean
	 */
	public static function isInvalidStr($string)
	{
		if (!$string) {
			return false;
		}
		return preg_match('#[!\#$%^&*(){}~`"\';:?+=<>/\[\]]+#', $string,$arr) ? true : false;
	}

	/**
	 * 用正则表达式验证邮证编码
	 *
	 * @param integer $num    所要验证的邮政编码
	 * @return boolean
	 */
	public static function isPostNum($num)
	{
		if (!$num) {
			return false;
		}
		return preg_match('#^[1-9][0-9]{5}$#', $num) ? true : false;
	}
	
	/**
	 * 用正则表达式验证是否整数
	 */
	public static function isInt($num, $negative = true)
	{
	    if (!$num) {
	        return false;
	    }
	    $reg = $negative ? '(-)?' : '';
	    $reg .= '[0-9]+';
	    return preg_match('#^'. $reg .'$#', $num) ? true : false;
	}
	
	/**
	 * 用正则表达式验证是否日期
	 */
	public static function isDate($str)
	{
	    if (!$str) {
	        return false;
	    }
	    $reg = '/^((((1[6-9]|[2-9][0-9])[0-9]{2})-(0?[13578]|1[02])-(0?[1-9]|[12][0-9]|3[01]))|(((1[6-9]|[2-9][0-9])[0-9]{2})-(0?[13456789]|1[012])-(0?[1-9]|[12][0-9]|30))|(((1[6-9]|[2-9][0-9])[0-9]{2})-0?2-(0?[1-9]|1[0-9]|2[0-8]))|(((1[6-9]|[2-9][0-9])(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))$/';
	    return preg_match($reg, $str) ? true : false;
	}
	
	/**
	 * 用正则表达式验证是否日期时间
	 */
	public static function isDateTime($str)
	{
	    if (!$str) {
	        return false;
	    }
	    $reg = '/^((((1[6-9]|[2-9][0-9])[0-9]{2})-(0?[13578]|1[02])-(0?[1-9]|[12][0-9]|3[01]))|(((1[6-9]|[2-9][0-9])[0-9]{2})-(0?[13456789]|1[012])-(0?[1-9]|[12][0-9]|30))|(((1[6-9]|[2-9][0-9])[0-9]{2})-0?2-(0?[1-9]|1[0-9]|2[0-8]))|(((1[6-9]|[2-9][0-9])(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-)) (20|21|22|23|[0-1]?[0-9]):[0-5]?[0-9]:[0-5]?[0-9]$/';
	    return preg_match($reg, $str) ? true : false;
	}

	/**
	 * 正则表达式验证身份证号码
	 *
	 * @param integer $num    所要验证的身份证号码
	 * @return boolean
	 */
	public static function isPersonalCard($num)
	{
		if (!$num) {
			return false;
		}
		return preg_match('#^[\d]{15}$|^[\d]{17}[0-9X]$#', $num) ? true : false;
	}

	/**
	 * 正则表达式验证IP地址, 注:仅限IPv4
	 *
	 * @param string $str    所要验证的IP地址
	 * @return boolean
	 */
	public static function isIp($str)
	{
		if (!$str) {
			return false;
		}
		if (!preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $str)) {
			return false;
		}
		$ipArray = explode('.', $str);
		//真实的ip地址每个数字不能大于255（0-255）
		return ($ipArray[0]<=255 && $ipArray[1]<=255 && $ipArray[2]<=255 && $ipArray[3]<=255) ? true : false;
	}

	/**
	 * 用正则表达式验证出版物的ISBN号
	 *
	 * @param integer $str    所要验证的ISBN号,通常是由13位数字构成
	 * @return boolean
	 */
	public static function isBookIsbn($str)
	{
		if (!$str) {
			return false;
		}
		return preg_match('#^978[\d]{10}$|^978-[\d]{10}$#', $str) ? true : false;
	}

	/**
	 * 用正则表达式验证手机号码(中国大陆区)
	 * @param integer $num    所要验证的手机号
	 * @return boolean
	 */
	public static function isMobile($num)
	{
		if (!$num) {
			return false;
		}
		return preg_match('#^1[34578]\d{9}$#', $num) ? true : false;
	}

	/**
	 * 检查字符串是否为空
	 *
	 * @access public
	 * @param string $string 字符串内容
	 * @return boolean
	 */
	public static function isMust($string = null)
	{
		//参数分析
		if (is_null($string)) {
			return false;
		}
		return $string == '' ? false : true;
	}

	/**
	 * 检查字符串长度
	 *
	 * @access public
	 * @param string $string 字符串内容
	 * @param integer $min 最小的字符串数
	 * @param integer $max 最大的字符串数
	 */
	public static function isLength($string = null, $min = 0, $max = 255)
	{
		//参数分析
		if (is_null($string)) {
			return false;
		}
		//获取字符串长度
		$length = strlen(trim($string));
		if($min>0 && $max>0) {
		  return (($length >= (int)$min) && ($length <= (int)$max)) ? true : false;
		} elseif($min>0 && $max==0) {
		  return ($length >= (int)$min) ? true : false;
		}  elseif($max>0 && $min==0) {
		  return ($length <= (int)$max) ? true : false;
		} 
	}
	
	/**
	 * 检查值得最大最小,数字与日期及字符串
	 *
	 */
	public static function isValue($str, $min = null, $max = null)
	{
	    if($min === null && $max === null) {
	        return false;
	    }
	    if($min !== null && $max !== null) {
	        return ($str>=$min && $str<=$max) ? true : false;
	    }elseif($min !== null && $max === null) {
	        return ($str>=$min) ? true : false;
	    }elseif($min === null && $max !== null) {
	        return ($str<=$max) ? true : false;
	    }
	    return false;
	}
}
