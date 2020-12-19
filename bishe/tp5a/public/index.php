<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//定义配置目录
define('CONF_PATH', __DIR__ . '/../config/');
////绑定到指定模块
//define('BIND_MODULE','index');
//绑定到指定控制器上
define('BIND_MODULE','index/Demo');
//定义配置文件类型
//define('CONF_EXT','.json');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
