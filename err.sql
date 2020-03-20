-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-03-20 15:09:13
-- 服务器版本： 5.7.26-log
-- PHP 版本： 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `err`
--

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_migrations`
--

CREATE TABLE `gongyijie_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `gongyijie_migrations`
--

INSERT INTO `gongyijie_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_03_18_101223_create_permission_tables', 1),
(2, '2020_03_18_165315_create_users_table', 1),
(4, '2020_03_20_103822_create_user_login_log_table', 2),
(5, '2020_03_20_110158_create_user_operate_log_table', 3);

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_model_has_permissions`
--

CREATE TABLE `gongyijie_model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_model_has_roles`
--

CREATE TABLE `gongyijie_model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `gongyijie_model_has_roles`
--

INSERT INTO `gongyijie_model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Model\\User', 1),
(2, 'App\\Model\\User', 2);

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_permissions`
--

CREATE TABLE `gongyijie_permissions` (
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
-- 转存表中的数据 `gongyijie_permissions`
--

INSERT INTO `gongyijie_permissions` (`id`, `parent_id`, `name`, `display_name`, `url`, `icon`, `guard_name`, `sort`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, '/v1/manager', '后台管理', '/v1/manager', 'mdi-palette', 'v1', 0, '0', '2019-12-23 19:27:02', '2019-12-23 19:27:02'),
(2, 1, '/v1/menu/index', '菜单管理', '/v1/menu/index', '', 'v1', 0, '0', '2019-12-23 19:27:37', '2019-12-23 19:27:48'),
(3, 2, '/v1/menu/store', '菜单添加', '/v1/menu/store', '', 'v1', 0, '0', '2019-12-23 19:27:37', '2019-12-23 19:27:48'),
(4, 2, '/v1/menu/update', '菜单修改', '/v1/menu/update', '', 'v1', 0, '0', '2019-12-23 19:27:37', '2019-12-23 19:27:48'),
(5, 2, '/v1/menu/del', '菜单删除', '/v1/menu/del', '', 'v1', 0, '0', '2019-12-23 19:27:37', '2019-12-23 19:27:48'),
(6, 1, '/v1/role/index', '角色管理', '/v1/role/index', '', 'v1', 0, '0', '2019-12-23 19:28:25', '2019-12-23 19:28:25'),
(7, 6, '/v1/role/store', '角色添加', '/v1/role/store', '', 'v1', 0, '0', '2019-12-23 19:28:25', '2019-12-23 19:28:25'),
(8, 6, '/v1/role/update', '角色修改', '/v1/role/update', '', 'v1', 0, '0', '2019-12-23 19:28:25', '2019-12-23 19:28:25'),
(9, 6, '/v1/role/del', '角色删除', '/v1/role/del', '', 'v1', 0, '0', '2019-12-23 19:28:25', '2019-12-23 19:28:25'),
(10, 6, '/v1/role/authorize', '角色授权', '/v1/role/authorize', '', 'v1', 0, '0', '2019-12-23 19:28:25', '2019-12-23 19:28:25'),
(11, 6, '/v1/role/auth', '角色授权修改', '/v1/role/auth', '', 'v1', 0, '0', '2019-12-23 19:28:25', '2019-12-23 19:28:25'),
(12, 1, '/v1/user/index', '管理员', '/v1/user/index', '', 'v1', 0, '0', '2019-12-23 19:28:44', '2019-12-23 19:28:44'),
(13, 12, '/v1/user/store', '管理员添加', '/v1/user/store', '', 'v1', 0, '0', '2019-12-23 19:28:44', '2019-12-23 19:28:44'),
(14, 12, '/v1/user/update', '管理员修改', '/v1/user/update', '', 'v1', 0, '0', '2019-12-23 19:28:44', '2019-12-23 19:28:44'),
(15, 12, '/v1/user/del', '管理员删除', '/v1/user/del', '', 'v1', 0, '0', '2019-12-23 19:28:44', '2019-12-23 19:28:44'),
(16, 12, '/v1/user/profile', '个人信息', '/v1/user/profile', '', 'v1', 0, '0', '2020-01-02 06:54:04', '2020-01-02 06:54:04'),
(17, 12, '/v1/user/info', '个人信息修改', '/v1/user/info', '', 'v1', 0, '0', '2020-01-02 06:54:28', '2020-01-02 06:54:28'),
(18, 12, '/v1/user/pwd', '密码修改', '/v1/user/pwd', '', 'v1', 0, '0', '2020-01-02 06:54:51', '2020-01-02 06:54:51'),
(19, 0, '/v1/index/index', '后台首页', '/v1/index/index', '', 'v1', 0, '1', '2020-01-02 06:54:51', '2020-01-02 06:54:51'),
(20, 0, '/v1/error/404', '404', '/v1/error/404', '', 'v1', 0, '1', '2020-03-19 15:18:07', '2020-03-19 15:18:07'),
(21, 0, '/v1/common/image', '图片上传', '/v1/common/image', '', 'v1', 0, '1', '2020-03-19 15:18:07', '2020-03-19 15:18:07'),
(22, 0, '/v1/login/logout', '退出', '/v1/login/logout', '', 'v1', 0, '1', '2020-03-20 15:05:52', '2020-03-20 15:05:52');

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_roles`
--

CREATE TABLE `gongyijie_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `gongyijie_roles`
--

INSERT INTO `gongyijie_roles` (`id`, `name`, `description`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, '超级管理员', '超级瓜里源', 'v1', '2020-03-19 13:44:58', '2020-03-19 13:44:58'),
(2, '管理员', '管理员', 'v1', '2020-03-19 13:45:20', '2020-03-19 13:45:20');

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_role_has_permissions`
--

CREATE TABLE `gongyijie_role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `gongyijie_role_has_permissions`
--

INSERT INTO `gongyijie_role_has_permissions` (`permission_id`, `role_id`) VALUES
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
(20, 1),
(21, 1),
(1, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2);

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_users`
--

CREATE TABLE `gongyijie_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `role` int(11) NOT NULL COMMENT '角色',
  `access` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否允许登录 0可以 1不可以',
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `gongyijie_users`
--

INSERT INTO `gongyijie_users` (`id`, `name`, `email`, `passwd`, `photo`, `role`, `access`, `ip`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'nicaineaa', 'admin@admin.com', '$2y$10$9Ahdh/MUtIhYr5XFp.ZFnuWh1ltUCDq3LUOasvE0oLw0VIZFwiISm', '/images/users/avatar.jpg', 1, 0, '124.64.63.98', NULL, '2020-03-19 13:47:09', '2020-03-20 13:57:47'),
(2, 'hahaa', 'haha@haha.com', '$2y$10$.qEhrBmC40aXbctmR9S8SuPO87EYh0HsoemnQPJz7iDqzC7RvqMXe', '', 2, 0, '', NULL, '2020-03-19 13:47:25', '2020-03-19 15:44:23');

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_user_login_log`
--

CREATE TABLE `gongyijie_user_login_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `gongyijie_user_login_log`
--

INSERT INTO `gongyijie_user_login_log` (`id`, `uid`, `ip`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '124.64.63.98', NULL, '2020-03-20 10:48:20', '2020-03-20 10:48:20'),
(2, 1, '124.64.63.98', NULL, '2020-03-20 12:25:30', '2020-03-20 12:25:30'),
(3, 1, '124.64.63.98', NULL, '2020-03-20 13:53:46', '2020-03-20 13:53:46'),
(4, 1, '124.64.63.98', NULL, '2020-03-20 13:58:16', '2020-03-20 13:58:16'),
(5, 1, '124.64.63.98', NULL, '2020-03-20 15:04:54', '2020-03-20 15:04:54'),
(6, 1, '124.64.63.98', NULL, '2020-03-20 15:05:23', '2020-03-20 15:05:23'),
(7, 1, '124.64.63.98', NULL, '2020-03-20 15:06:46', '2020-03-20 15:06:46');

-- --------------------------------------------------------

--
-- 表的结构 `gongyijie_user_operate_log`
--

CREATE TABLE `gongyijie_user_operate_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `param` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `gongyijie_user_operate_log`
--

INSERT INTO `gongyijie_user_operate_log` (`id`, `uid`, `ip`, `param`, `deleted_at`, `created_at`, `updated_at`) VALUES
(31, 1, '124.64.63.98', '{\"name\":\"菜单管理\",\"get\":[],\"post\":[]}', NULL, '2020-03-20 15:06:30', '2020-03-20 15:06:30'),
(32, 1, '124.64.63.98', '{\"name\":\"退出\",\"get\":[],\"post\":[]}', NULL, '2020-03-20 15:06:35', '2020-03-20 15:06:35'),
(33, 1, '124.64.63.98', '{\"name\":\"后台首页\",\"get\":[],\"post\":[]}', NULL, '2020-03-20 15:06:46', '2020-03-20 15:06:46'),
(34, 1, '124.64.63.98', '{\"name\":\"后台首页\",\"get\":[],\"post\":[]}', NULL, '2020-03-20 15:07:51', '2020-03-20 15:07:51'),
(35, 1, '124.64.63.98', '{\"name\":\"后台首页\",\"get\":[],\"post\":[]}', NULL, '2020-03-20 15:07:53', '2020-03-20 15:07:53');

--
-- 转储表的索引
--

--
-- 表的索引 `gongyijie_migrations`
--
ALTER TABLE `gongyijie_migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `gongyijie_model_has_permissions`
--
ALTER TABLE `gongyijie_model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- 表的索引 `gongyijie_model_has_roles`
--
ALTER TABLE `gongyijie_model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- 表的索引 `gongyijie_permissions`
--
ALTER TABLE `gongyijie_permissions`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `gongyijie_roles`
--
ALTER TABLE `gongyijie_roles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `gongyijie_role_has_permissions`
--
ALTER TABLE `gongyijie_role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- 表的索引 `gongyijie_users`
--
ALTER TABLE `gongyijie_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_id_unique` (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_deleted_at_index` (`deleted_at`);

--
-- 表的索引 `gongyijie_user_login_log`
--
ALTER TABLE `gongyijie_user_login_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_log_uid_index` (`uid`);

--
-- 表的索引 `gongyijie_user_operate_log`
--
ALTER TABLE `gongyijie_user_operate_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_operate_log_uid_index` (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `gongyijie_migrations`
--
ALTER TABLE `gongyijie_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `gongyijie_permissions`
--
ALTER TABLE `gongyijie_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `gongyijie_roles`
--
ALTER TABLE `gongyijie_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `gongyijie_users`
--
ALTER TABLE `gongyijie_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `gongyijie_user_login_log`
--
ALTER TABLE `gongyijie_user_login_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `gongyijie_user_operate_log`
--
ALTER TABLE `gongyijie_user_operate_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 限制导出的表
--

--
-- 限制表 `gongyijie_model_has_permissions`
--
ALTER TABLE `gongyijie_model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `gongyijie_permissions` (`id`) ON DELETE CASCADE;

--
-- 限制表 `gongyijie_model_has_roles`
--
ALTER TABLE `gongyijie_model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `gongyijie_roles` (`id`) ON DELETE CASCADE;

--
-- 限制表 `gongyijie_role_has_permissions`
--
ALTER TABLE `gongyijie_role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `gongyijie_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `gongyijie_roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

