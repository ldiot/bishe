<?php

return array(
	'__pattern__'    => array(
		'name' => '\w+',
	),

	'/'              => 'index/index/index', // 首页访问路由
    '/help'    =>'index/index/getHelp',
   	'admin/login'    => 'admin/index/login',
	'admin/logout'   => 'admin/index/logout',

);