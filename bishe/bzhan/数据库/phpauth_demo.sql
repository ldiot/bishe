/*
 Navicat Premium Data Transfer

 Source Server         : 阿里云
 Source Server Type    : MySQL
 Source Server Version : 50556
 Source Host           : localhost:3306
 Source Schema         : phpauth_demo

 Target Server Type    : MySQL
 Target Server Version : 50556
 File Encoding         : 65001

 Date: 13/03/2018 08:09:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for zhi_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `zhi_auth_group`;
CREATE TABLE `zhi_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户组所属模块',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '组类型',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zhi_auth_group
-- ----------------------------
INSERT INTO `zhi_auth_group` VALUES (1, 'admin', '1', '超级管理员组', '拥有最高权限', 1, '2,1');

-- ----------------------------
-- Table structure for zhi_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `zhi_auth_group_access`;
CREATE TABLE `zhi_auth_group_access`  (
  `uid` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户组id',
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户所属组表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of zhi_auth_group_access
-- ----------------------------
INSERT INTO `zhi_auth_group_access` VALUES (1, 1);
INSERT INTO `zhi_auth_group_access` VALUES (9, 1);

-- ----------------------------
-- Table structure for zhi_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `zhi_auth_rule`;
CREATE TABLE `zhi_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-url;2-主菜单',
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `group` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '权限节点分组',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `module`(`module`, `status`, `type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 62 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限规则表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zhi_auth_rule
-- ----------------------------
INSERT INTO `zhi_auth_rule` VALUES (40, 'admin', 1, 'admin/group/access', '权限列表', '会员', 1, '');
INSERT INTO `zhi_auth_rule` VALUES (39, 'admin', 1, 'admin/group/index', '用户组列表', '会员', 1, '');
INSERT INTO `zhi_auth_rule` VALUES (34, 'admin', 1, 'admin/index/main', '系统预览', '首页', 1, '');
INSERT INTO `zhi_auth_rule` VALUES (35, 'admin', 1, 'admin/index/clear', '更新缓存', '首页', 1, '');
INSERT INTO `zhi_auth_rule` VALUES (36, 'admin', 1, 'admin/config/group', '配置管理', '首页', 1, '');
INSERT INTO `zhi_auth_rule` VALUES (37, 'admin', 1, 'admin/menu/index', '菜单管理', '首页', 1, '');
INSERT INTO `zhi_auth_rule` VALUES (38, 'admin', 1, 'admin/user/index', '用户列表', '会员', 1, '');

-- ----------------------------
-- Table structure for zhi_config
-- ----------------------------
DROP TABLE IF EXISTS `zhi_config`;
CREATE TABLE `zhi_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'text' COMMENT '配置类型',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置分组',
  `extra` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置说明',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '小图标',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '配置值',
  `sort` smallint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `group`(`group`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 72 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '配置详情表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zhi_config
-- ----------------------------
INSERT INTO `zhi_config` VALUES (1, 'config_group_list', 'textarea', '配置分组', 99, '', '', '', 1447305542, 1511415876, 1, '1:基本\r\n99:系统', 0);
INSERT INTO `zhi_config` VALUES (3, 'auth_config', 'textarea', 'Auth配置', 99, '', '自定义Auth.class.php类配置', '', 1379409310, 1379409564, 1, 'AUTH_ON:1\r\nAUTH_TYPE:2', 8);
INSERT INTO `zhi_config` VALUES (14, 'web_site_title', 'text', '网站标题', 1, '', '网站标题前台显示标题', '', 1378898976, 1379235274, 1, '智云产品授权与更新系统', 0);
INSERT INTO `zhi_config` VALUES (15, 'web_site_url', 'text', '网站URL', 1, '', '网站网址', '', 1378898976, 1379235274, 1, 'http://demo.auth.zhiyunzhushou.com', 1);
INSERT INTO `zhi_config` VALUES (23, 'user_group_type', 'textarea', '会员分组类别', 99, '', '', '', 1449196835, 1511415858, 1, 'admin:后台管理员', 1);
INSERT INTO `zhi_config` VALUES (24, 'config_type_list', 'textarea', '字段类型', 99, '', '', '', 1459136529, 1459136529, 1, 'text:单行文本:varchar\r\nstring:字符串:int\r\npassword:密码:varchar\r\ntextarea:多行文本:text\r\nbool:布尔型:int\r\nselect:选择:varchar\r\nnum:数字:int\r\ndecimal:金额:decimal\r\ntags:标签:varchar\r\ndatetime:时间控件:int\r\ndate:日期控件:varchar\r\neditor:编辑器:text\r\nbind:模型绑定:int\r\nimage:图片上传:int\r\nimages:多图上传:varchar\r\nattach:文件上传:varchar', 0);
INSERT INTO `zhi_config` VALUES (68, 'auth_server_domain', 'text', '授权服务器域名', 1, '', '', '', 1519823599, 1519823609, 1, 'auth.zhiyunzhushou.com', 0);
INSERT INTO `zhi_config` VALUES (69, 'auth_client_id', 'string', '本客户端ID', 1, '', '', '', 1519823640, 1519823640, 1, '1', 0);
INSERT INTO `zhi_config` VALUES (70, 'auth_client_code', 'text', '客户端秘钥', 1, '', '', '', 1519823690, 1519823698, 1, 'clienttestcom', 0);
INSERT INTO `zhi_config` VALUES (71, 'auth_zip_dir', 'text', '更新包下载目录', 1, '', '例如 upgrade/ 目录必须可写是相对根目录文件夹', '', 1519823777, 1519823777, 1, 'upgrade/', 0);

-- ----------------------------
-- Table structure for zhi_member
-- ----------------------------
DROP TABLE IF EXISTS `zhi_member`;
CREATE TABLE `zhi_member`  (
  `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户密码',
  `nickname` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '邮箱地址',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '手机号码',
  `logo` int(11) DEFAULT NULL COMMENT '头像',
  `user_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '用户类型',
  `sex` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '1000-01-01' COMMENT '生日',
  `qq` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'qq号',
  `score` mediumint(8) NOT NULL DEFAULT 0 COMMENT '用户积分',
  `signature` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '用户签名',
  `salt` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码盐值',
  `login` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录次数',
  `reg_ip` bigint(20) NOT NULL DEFAULT 0 COMMENT '注册IP',
  `reg_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT 0 COMMENT '最后登录IP',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '会员状态',
  PRIMARY KEY (`uid`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zhi_member
-- ----------------------------
INSERT INTO `zhi_member` VALUES (1, 'admin', '2616a3e0774ed5c3eb910e0125fec759', 'admin', 'admin@admin.com', '', NULL, 'admin', 0, '0000-00-00', '', 0, '', 'XSjGdR', 12, 0, 1507431869, 2130706433, 1511230385, 1);
INSERT INTO `zhi_member` VALUES (9, 'admindemo', 'c66269619c3f46a0c964f3f77dfa4037', 'admindemo', NULL, '', NULL, 'admin', 0, '0000-00-00', '', 0, '', 'zfJgyo', 0, 0, 1519978142, 0, 0, 1);

-- ----------------------------
-- Table structure for zhi_menu
-- ----------------------------
DROP TABLE IF EXISTS `zhi_menu`;
CREATE TABLE `zhi_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类图标',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级分类ID',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序（同级有效）',
  `url` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(2) DEFAULT 0,
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '分组',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 79 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zhi_menu
-- ----------------------------
INSERT INTO `zhi_menu` VALUES (1, '首页', 'home', 0, 1, 'admin/index/index', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (75, '会员', 'user', 0, 2, 'admin/user/index', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (76, '升级日志', 'cloud', 1, 5, 'admin/client/uplog', 0, '产品管理', 0);
INSERT INTO `zhi_menu` VALUES (50, '后台首页', 'dashboard', 1, 0, 'admin/index/index', 0, '系统配置', 0);
INSERT INTO `zhi_menu` VALUES (7, '更新缓存', 'refresh', 1, 0, 'admin/index/clear', 0, '系统配置', 0);
INSERT INTO `zhi_menu` VALUES (8, '配置管理', 'cog', 1, 0, 'admin/config/group', 0, '系统配置', 0);
INSERT INTO `zhi_menu` VALUES (9, '菜单管理', 'book', 1, 0, 'admin/menu/index', 0, '系统配置', 0);
INSERT INTO `zhi_menu` VALUES (16, '用户列表', 'user', 75, 0, 'admin/user/index', 0, '用户管理', 0);
INSERT INTO `zhi_menu` VALUES (17, '用户组表', 'sitemap', 75, 0, 'admin/group/index', 0, '用户管理', 0);
INSERT INTO `zhi_menu` VALUES (18, '权限列表', 'wrench', 75, 0, 'admin/group/access', 0, '用户管理', 0);
INSERT INTO `zhi_menu` VALUES (71, '产品列表', 'reorder', 1, 1, 'admin/product/index', 0, '产品管理', 0);
INSERT INTO `zhi_menu` VALUES (72, '产品版本管理 ', 'calendar', 1, 2, 'admin/product/verlist', 0, '产品管理', 0);
INSERT INTO `zhi_menu` VALUES (73, '授权客户端', 'desktop', 1, 3, 'admin/client/index', 0, '产品管理', 0);
INSERT INTO `zhi_menu` VALUES (60, '添加菜单', '', 9, 0, 'admin/menu/add', 1, '系统配置', 0);
INSERT INTO `zhi_menu` VALUES (61, '编辑菜单', '', 9, 0, 'admin/menu/edit', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (62, '配置列表', '', 8, 0, 'admin/config/index', 1, '', 0);
INSERT INTO `zhi_menu` VALUES (63, '添加配置', '', 8, 0, 'admin/config/add', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (64, ' 添加用户组', '', 17, 0, 'admin/group/add', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (65, ' 编辑用户组', '', 17, 0, 'admin/group/edit', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (66, '编辑节点', '', 18, 0, 'admin/group/editnode', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (67, '添加节点', '', 18, 0, 'admin/group/addnode', 0, '', 0);
INSERT INTO `zhi_menu` VALUES (74, '盗版列表', 'cloud-download', 1, 4, 'admin/client/noauthlist', 0, '产品管理', 0);
INSERT INTO `zhi_menu` VALUES (77, '客户端实例代码包', 'screenshot', 1, 6, 'admin/client/code', 0, '产品管理', 0);
INSERT INTO `zhi_menu` VALUES (78, '编辑配置', '', 8, 0, 'admin/config/edit', 0, '', 0);

-- ----------------------------
-- Table structure for zhi_picture
-- ----------------------------
DROP TABLE IF EXISTS `zhi_picture`;
CREATE TABLE `zhi_picture`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 76 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zhi_picture
-- ----------------------------
INSERT INTO `zhi_picture` VALUES (75, '/uploads/picture/20180103/88cdcd3dec81400e161af2d1fd6ddaa1.png', '/uploads/picture/20180103/88cdcd3dec81400e161af2d1fd6ddaa1.png', 'ec8292a25ef4da7e4fe4f3ff44b92fe7', '661569e6d9e0dd760d5a0f43527cd6b7b22ef783', 1, 1514968706);
INSERT INTO `zhi_picture` VALUES (74, '/uploads/picture/20180103/a055a7fb310b2aa09897d0ebd1491c1b.jpg', '/uploads/picture/20180103/a055a7fb310b2aa09897d0ebd1491c1b.jpg', '2524025389cc6d43ac046b7e0fc47338', '9ded584bfcca87cc5bd4b1c2a9a5cb2a02824f73', 1, 1514968694);

-- ----------------------------
-- Table structure for zhi_product
-- ----------------------------
DROP TABLE IF EXISTS `zhi_product`;
CREATE TABLE `zhi_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of zhi_product
-- ----------------------------
INSERT INTO `zhi_product` VALUES (2, '智云授权与更新系统', '对公司项目进行授权与代码自更新功能。联系qq:\n304455977', 1519268569);

-- ----------------------------
-- Table structure for zhi_product_client
-- ----------------------------
DROP TABLE IF EXISTS `zhi_product_client`;
CREATE TABLE `zhi_product_client`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `product_id` int(11) DEFAULT 0,
  `qq` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mobile` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `auth_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cur_version` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ips` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `domains` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `startdt` int(11) DEFAULT 0,
  `enddt` int(11) DEFAULT 0,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of zhi_product_client
-- ----------------------------
INSERT INTO `zhi_product_client` VALUES (1, '智云演示客户端', 2, '304455977', '13577678822', 'fdsafa', 1519292482, 'clienttestcom', '1.1', '', 'shouquan.test.com', 662356500, 1574909400, '32', 1);

-- ----------------------------
-- Table structure for zhi_product_client_noauth
-- ----------------------------
DROP TABLE IF EXISTS `zhi_product_client_noauth`;
CREATE TABLE `zhi_product_client_noauth`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT 0,
  `domain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT 0,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of zhi_product_client_noauth
-- ----------------------------
INSERT INTO `zhi_product_client_noauth` VALUES (2, 2, 'test.test.com', '127.0.0.1', 1519636841, '');
INSERT INTO `zhi_product_client_noauth` VALUES (3, 2, 'test.test.com', '127.0.0.1', 1519636904, '');
INSERT INTO `zhi_product_client_noauth` VALUES (4, 2, 'test.test.com', '127.0.0.1', 1519636913, '');
INSERT INTO `zhi_product_client_noauth` VALUES (5, 2, 'test.test.com', '127.0.0.1', 1519637011, '');
INSERT INTO `zhi_product_client_noauth` VALUES (6, 2, 'test.test.com', '127.0.0.1', 1519638364, '');

-- ----------------------------
-- Table structure for zhi_product_client_uplog
-- ----------------------------
DROP TABLE IF EXISTS `zhi_product_client_uplog`;
CREATE TABLE `zhi_product_client_uplog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT 0,
  `client_id` int(11) DEFAULT 0,
  `domain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `source_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `to_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT 0,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of zhi_product_client_uplog
-- ----------------------------
INSERT INTO `zhi_product_client_uplog` VALUES (30, 2, 1, 'demo.auth.zhiyunzhushou.com', '1.0', '1.1', 1519721281, '升级成功');

-- ----------------------------
-- Table structure for zhi_product_version
-- ----------------------------
DROP TABLE IF EXISTS `zhi_product_version`;
CREATE TABLE `zhi_product_version`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT 0,
  `vernum` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `upzipname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `upcontent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `create_time` int(11) DEFAULT 0,
  `up_sort` int(11) DEFAULT 0,
  `status` tinyint(2) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of zhi_product_version
-- ----------------------------
INSERT INTO `zhi_product_version` VALUES (1, 2, '1.1', 'http://shouquan.test.com/upzip/1.0.1.zip', '更新了客户端sdk\n后台逻辑代码优化 ', 1519273069, 2, 1);

SET FOREIGN_KEY_CHECKS = 1;
