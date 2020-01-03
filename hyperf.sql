-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-01-03 15:23:15
-- 服务器版本： 5.7.26-log
-- PHP 版本： 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `swoole`
--

-- --------------------------------------------------------

--
-- 表的结构 `ysj_admins`
--

CREATE TABLE `ysj_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` char(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `photo` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `role` tinyint(3) UNSIGNED NOT NULL COMMENT '角色',
  `access` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '是否允许登录',
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `ysj_admins`
--

INSERT INTO `ysj_admins` (`id`, `name`, `email`, `passwd`, `photo`, `role`, `access`, `ip`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'nicaine', 'admin@admin.com', '$2y$10$QMASg6bubIBuCZWnWabhGeHYeDQxjujPKYvX1sRvEBfHdK.QD89UW', '', 1, '0', '111.196.235.227', NULL, '2019-12-15 08:00:00', '2019-12-28 00:34:29'),
(2, 'test', 'test@test.com', '$2y$10$TI8WjPpw8jqaAr/oeOAVSua4RKY4RO7inkC.vP4W4NJHrP3qhiWDa', '', 1, '0', '124.64.56.74', NULL, '2020-01-03 07:22:43', '2020-01-03 07:22:54');

-- --------------------------------------------------------

--
-- 表的结构 `ysj_migrations`
--

CREATE TABLE `ysj_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `ysj_migrations`
--

INSERT INTO `ysj_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_18_112324_create_admins_table', 1),
(2, '2019_12_18_175556_create_sets_table', 1),
(3, '2019_12_20_113439_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ysj_model_has_permissions`
--

CREATE TABLE `ysj_model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ysj_model_has_roles`
--

CREATE TABLE `ysj_model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `ysj_model_has_roles`
--

INSERT INTO `ysj_model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Model\\Admin', 2);

-- --------------------------------------------------------

--
-- 表的结构 `ysj_permissions`
--

CREATE TABLE `ysj_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sort` smallint(6) NOT NULL COMMENT '排序，数字越大越在前面',
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '是否显示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `ysj_permissions`
--

INSERT INTO `ysj_permissions` (`id`, `parent_id`, `name`, `display_name`, `url`, `icon`, `guard_name`, `sort`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'system/manager', '后台管理', '/system/manager', 'mdi-palette', '', 0, '0', '2019-12-24 11:27:02', '2019-12-24 11:27:02'),
(2, 1, 'system/menu/index', '菜单管理', '/system/menu/index', '', '', 0, '0', '2019-12-24 11:27:37', '2019-12-24 11:27:48'),
(3, 2, 'system/menu/store', '菜单添加', '/system/menu/store', '', '', 0, '0', '2019-12-24 11:27:37', '2019-12-24 11:27:48'),
(4, 2, 'system/menu/update', '菜单修改', '/system/menu/update', '', '', 0, '0', '2019-12-24 11:27:37', '2019-12-24 11:27:48'),
(5, 2, 'system/menu/del', '菜单删除', '/system/menu/del', '', '', 0, '0', '2019-12-24 11:27:37', '2019-12-24 11:27:48'),
(6, 1, 'system/role/index', '角色管理', '/system/role/index', '', '', 0, '0', '2019-12-24 11:28:25', '2019-12-24 11:28:25'),
(7, 6, 'system/role/store', '角色添加', '/system/role/store', '', '', 0, '0', '2019-12-24 11:28:25', '2019-12-24 11:28:25'),
(8, 6, 'system/role/update', '角色修改', '/system/role/update', '', '', 0, '0', '2019-12-24 11:28:25', '2019-12-24 11:28:25'),
(9, 6, 'system/role/del', '角色删除', '/system/role/del', '', '', 0, '0', '2019-12-24 11:28:25', '2019-12-24 11:28:25'),
(10, 6, 'system/role/authorize', '角色授权', '/system/role/authorize', '', '', 0, '0', '2019-12-24 11:28:25', '2019-12-24 11:28:25'),
(11, 6, 'system/role/auth', '角色授权修改', '/system/role/auth', '', '', 0, '0', '2019-12-24 11:28:25', '2019-12-24 11:28:25'),
(12, 1, 'system/admin/index', '管理员', '/system/admin/index', '', '', 0, '0', '2019-12-24 11:28:44', '2019-12-24 11:28:44'),
(13, 12, 'system/admin/store', '管理员添加', '/system/admin/store', '', '', 0, '0', '2019-12-24 11:28:44', '2019-12-24 11:28:44'),
(14, 12, 'system/admin/update', '管理员修改', '/system/admin/update', '', '', 0, '0', '2019-12-24 11:28:44', '2019-12-24 11:28:44'),
(15, 12, 'system/admin/del', '管理员删除', '/system/admin/del', '', '', 0, '0', '2019-12-24 11:28:44', '2019-12-24 11:28:44'),
(16, 1, 'system/set/upload', '设置', '/system/set/upload', '', '', 0, '0', '2019-12-28 00:44:34', '2019-12-28 00:45:06'),
(17, 16, 'system/set/update', '设置修改', '/system/set/update', '', '', 0, '1', '2019-12-28 05:25:34', '2019-12-28 05:25:34'),
(18, 12, 'system/admin/profile', '个人信息', '/system/admin/profile', '', '', 0, '0', '2020-01-02 22:54:04', '2020-01-02 22:54:04'),
(19, 12, 'system/admin/info', '个人信息修改', '/system/admin/info', '', '', 0, '0', '2020-01-02 22:54:28', '2020-01-02 22:54:28'),
(20, 12, 'system/admin/pwd', '密码修改', '/system/admin/pwd', '', '', 0, '0', '2020-01-02 22:54:51', '2020-01-02 22:54:51');

-- --------------------------------------------------------

--
-- 表的结构 `ysj_roles`
--

CREATE TABLE `ysj_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `ysj_roles`
--

INSERT INTO `ysj_roles` (`id`, `name`, `description`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, '超级管理员', '超级管理员', '', '2020-01-03 07:22:15', '2020-01-03 07:22:15');

-- --------------------------------------------------------

--
-- 表的结构 `ysj_role_has_permissions`
--

CREATE TABLE `ysj_role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `ysj_role_has_permissions`
--

INSERT INTO `ysj_role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ysj_sets`
--

CREATE TABLE `ysj_sets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `descript` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '描述',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `ysj_sets`
--

INSERT INTO `ysj_sets` (`id`, `key`, `descript`, `value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'img_upload_size', '图片上传大小', '100', NULL, '2019-12-19 08:00:00', '2019-12-10 08:00:00'),
(2, 'img_upload_type', '图片类型', 'png,jpeg,jpg,gif', NULL, '2019-12-03 08:00:00', '2019-12-01 08:00:00');

--
-- 转储表的索引
--

--
-- 表的索引 `ysj_admins`
--
ALTER TABLE `ysj_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_id_unique` (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_deleted_at_index` (`deleted_at`);

--
-- 表的索引 `ysj_migrations`
--
ALTER TABLE `ysj_migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `ysj_model_has_permissions`
--
ALTER TABLE `ysj_model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- 表的索引 `ysj_model_has_roles`
--
ALTER TABLE `ysj_model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- 表的索引 `ysj_permissions`
--
ALTER TABLE `ysj_permissions`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `ysj_roles`
--
ALTER TABLE `ysj_roles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `ysj_role_has_permissions`
--
ALTER TABLE `ysj_role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- 表的索引 `ysj_sets`
--
ALTER TABLE `ysj_sets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sets_key_unique` (`key`),
  ADD KEY `sets_deleted_at_index` (`deleted_at`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `ysj_admins`
--
ALTER TABLE `ysj_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `ysj_migrations`
--
ALTER TABLE `ysj_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `ysj_permissions`
--
ALTER TABLE `ysj_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `ysj_roles`
--
ALTER TABLE `ysj_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `ysj_sets`
--
ALTER TABLE `ysj_sets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 限制导出的表
--

--
-- 限制表 `ysj_model_has_permissions`
--
ALTER TABLE `ysj_model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `ysj_permissions` (`id`) ON DELETE CASCADE;

--
-- 限制表 `ysj_model_has_roles`
--
ALTER TABLE `ysj_model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ysj_roles` (`id`) ON DELETE CASCADE;

--
-- 限制表 `ysj_role_has_permissions`
--
ALTER TABLE `ysj_role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `ysj_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ysj_roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
