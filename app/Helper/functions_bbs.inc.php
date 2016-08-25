<?php
use PhpParser\Node\Expr\Array_;

if( ! function_exists('furniture_type'))
{
    /**
     * 家具分类
     */
    function furniture_type()
    {
        $api_data = array();
    
        $api_data[1] = '桌子';
        $api_data[2] = '椅子';
        $api_data[3] = '沙发';
        $api_data[4] = '茶几';
        $api_data[5] = '装饰品';
        $api_data[6] = '摆件';
        $api_data[7] = '挂件';
        $api_data[8] = '灯具';
        $api_data[9] = '收纳';
        $api_data[10] = '柜子';
        $api_data[11] = '电子元素';
        $api_data[12] = '创意';
        $api_data[13] = '其他';
    
        return $api_data;
    }
}

if( ! function_exists('build_stage'))
{
    /**
     * 施工阶段
     */
    function build_stage()
    {
        $api_data = array();
    
        $api_data[1] = '水电工程';
        $api_data[2] = '泥瓦工程';
        $api_data[3] = '木工工程';
        $api_data[4] = '油漆工程';
        $api_data[5] = '厨卫工程';
        $api_data[6] = '家居工程';
        $api_data[7] = '环保安全';
        $api_data[8] = '收房验房';
    
        return $api_data;
    }
}

if( ! function_exists('dhtmlspecialchars'))
{
    /**
     * 
     * @param unknown $string
     * @param string $flags
     * @return unknown
     */
    function dhtmlspecialchars($string, $flags = null)
    {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = dhtmlspecialchars($val, $flags);
            }
        } else {
            if($flags === null) {
                $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
                if(strpos($string, '&amp;#') !== false) {
                    $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
                }
            } else {
                if(PHP_VERSION < '5.4.0') {
                    $string = htmlspecialchars($string, $flags);
                } else {
                    if(strtolower(CHARSET) == 'utf-8') {
                        $charset = 'UTF-8';
                    } else {
                        $charset = 'ISO-8859-1';
                    }
                    $string = htmlspecialchars($string, $flags, $charset);
                }
            }
        }
        return $string;
    }
}


if( ! function_exists('setstatus'))
{
    function setstatus($position, $value, $baseon = null) {
        $t = pow(2, $position - 1);
        if($value) {
            $t = $baseon | $t;
        } elseif ($baseon !== null) {
            $t = $baseon & ~$t;
        } else {
            $t = ~$t;
        }
        return $t & 0xFFFF;
    }
}
if( ! function_exists('checkbbcodes'))
{
    function checkbbcodes($message, $bbcodeoff) {
        return !$bbcodeoff && (!strpos($message, '[/') && !strpos($message, '[hr]')) ? -1 : $bbcodeoff;
    }
}
 
 
if( ! function_exists('checksmilies'))
{
    function checksmilies($message, $smileyoff, $cache=null) {
         if($smileyoff) {
             return 1;
         } else {
             if(!empty($cache['smileycodes']) && is_array($cache['smileycodes'])) {
                 foreach($cache['smileycodes'] as $id => $code) {
                     if(strpos($message, $code) !== FALSE) {
                         return 0;
                     }
                 }
             }
             return -1;
         }
    }
}

if( ! function_exists('getsortedoptionlist'))
{
    function getsortedoptionlist($g_forum_optionlist) {
        $forum_optionlist = $g_forum_optionlist;
        
        foreach($g_forum_optionlist as $key => $value) {
            $choicesarr = isset($value['choices'])?$value['choices']:[];
//             uksort($choicesarr, 'cmpchoicekey');
            $forum_optionlist[$key]['choices'] = $choicesarr;
        }
        $forum_optionlist = optionlistxml($forum_optionlist, 's');
        $forum_optionlist = '<?xml version="1.0" encoding="UTF-8"?>'."".'<forum_optionlist>'.$forum_optionlist.'</forum_optionlist>';
        return $forum_optionlist;
    }
}

if( ! function_exists('optionlistxml'))
{
    function optionlistxml($input, $pre = '') {
        $str = '';
        foreach($input as $key => $value) {
            $key = $pre.strval($key);
            if(is_array($value)) {
                $str .= "<$key>";
                $str .= optionlistxml($value, $pre);
                $str .="</$key>";
            } else {
                if(is_bool($value)) {
                    $value = ($value == true) ? 'true' : 'false';
                }
                $value = str_replace("\r\n", '<br>', $value);
                if(dhtmlspecialchars($value) != $value) {
                    $str .= "<$key><![CDATA[$value]]></$key>";
                } else {
                    $str .= "<$key>$value</$key>";
                }
            }
        }
        return $str;
    }
}