<?php
return array(
	//'配置项'=>'配置值'
    'URL_MODEL' => 2,

    'TMPL_TEMPLATE_SUFFIX' => '.php',     // 默认模板文件后缀

    'DEFAULT_MODULE'        =>  'Home',  // 默认模块
    'MODULE_ALLOW_LIST'     =>  array('Home', 'Admin'),    // 允许访问的模块列表

    'OAUTH2_TABLES' => array(
        'CODES' => 'oauth_codes',
        'CLIENTS' => 'oauth_clients',
        'TOKEN' => 'oauth_token'
    ),

    'DB_TYPE'   => '', // 数据库类型
    'DB_HOST'   => '', // 服务器地址
    'DB_NAME'   => '', // 数据库名
    'DB_USER'   => '', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀
);