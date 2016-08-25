<?php
/**
 *  全局的常量配置
 *  @author  wangzhoudong  <wangzhoudong@foxmail.com>
 *  @version    1.0
 *  @date 2015年10月16日
 *
 */
// =====================返回状态 ================== // 
define("APP_PATH",str_replace('\\', '/', substr(__DIR__, 0,-6)));
define("SYSTEM_TIME",time());
define("PAGE_NUMS", 10);
define("PAGE_MAX_NUMS",50);

//用户Session
//网站登录session
define("LOGIN_MARK_SESSION_KEY", 'LOGIN_MARK_SESdddSIONaaaaaa33ddsssdaadddaa');
//网站管理角色
define("WEB_ADMIN_ROLE", 'ROLE_WEB_ADMIN');

define("USER_ROOT_ID", 1);//定义 超级管理员ID
define("USER_ROOT_EMAIL", 'root');//定义 超级管理员ID





