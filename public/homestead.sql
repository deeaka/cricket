-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table',	1),
('2016_05_17_082113_create_courses_table',	1),
('2016_05_17_090322_create_lessons_table',	1),
('2016_05_17_111743_create_lesson_files_table',	1),
('2016_05_23_114206_create_roles_table',	1),
('2016_05_23_122620_create_users_table',	1),
('2016_05_23_122621_create_user_role_table',	1),
('2016_05_24_045028_create_students_table',	1),
('2016_05_24_045029_create_course_student_table',	1),
('2016_05_24_092415_create_lecturers_table',	1),
('2016_05_24_092744_create_course_lecturer_table',	1),
('2016_05_28_202808_add_published_to_lessons_table',	1),
('2016_06_06_075208_add_image_to_courses_table',	1),
('2016_06_14_065038_add_avatar_to_users',	1),
('2016_06_19_060821_add_company_to_users',	1),
('2019_06_25_072316_create_mt_team_table',	2),
('2019_06_27_072317_create_mt_player_table',	2),
('2019_07_02_072317_create_mt_match_table',	2);

DROP TABLE IF EXISTS `mt_match_tbl`;
CREATE TABLE `mt_match_tbl` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_team_id` bigint(20) unsigned NOT NULL,
  `second_team_id` bigint(20) unsigned NOT NULL,
  `winner_team_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mt_match_tbl_first_team_id_index` (`first_team_id`),
  KEY `mt_match_tbl_second_team_id_index` (`second_team_id`),
  KEY `mt_match_tbl_winner_team_id_index` (`winner_team_id`),
  CONSTRAINT `mt_match_tbl_first_team_id_foreign` FOREIGN KEY (`first_team_id`) REFERENCES `mt_team_master` (`team_id`) ON DELETE CASCADE,
  CONSTRAINT `mt_match_tbl_second_team_id_foreign` FOREIGN KEY (`second_team_id`) REFERENCES `mt_team_master` (`team_id`) ON DELETE CASCADE,
  CONSTRAINT `mt_match_tbl_winner_team_id_foreign` FOREIGN KEY (`winner_team_id`) REFERENCES `mt_team_master` (`team_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mt_match_tbl` (`id`, `first_team_id`, `second_team_id`, `winner_team_id`, `created_at`, `updated_at`) VALUES
(1,	10,	11,	10,	'2019-09-29 21:18:21',	'2019-09-29 21:18:21'),
(2,	10,	11,	10,	'2019-09-29 16:47:34',	'2019-09-29 16:47:34'),
(3,	10,	11,	10,	'2019-09-29 16:49:32',	'2019-09-29 16:49:32'),
(4,	10,	11,	10,	'2019-09-29 16:51:47',	'2019-09-29 16:51:47'),
(5,	10,	11,	10,	'2019-09-29 16:51:58',	'2019-09-29 16:51:58'),
(6,	11,	12,	11,	'2019-09-30 11:11:55',	'2019-09-30 11:11:55');

DROP TABLE IF EXISTS `mt_player_tbl`;
CREATE TABLE `mt_player_tbl` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `jsy_number` int(11) NOT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_uri` text COLLATE utf8_unicode_ci,
  `country` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `matches` int(11) NOT NULL DEFAULT '0',
  `run` int(11) NOT NULL DEFAULT '0',
  `highest_scores` int(11) NOT NULL DEFAULT '0',
  `hundreds` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mt_player_tbl_jsy_number_unique` (`jsy_number`),
  KEY `mt_player_tbl_team_id_foreign` (`team_id`),
  KEY `mt_player_tbl_jsy_number_index` (`jsy_number`),
  CONSTRAINT `mt_player_tbl_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `mt_team_master` (`team_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mt_player_tbl` (`id`, `team_id`, `jsy_number`, `first_name`, `last_name`, `image_uri`, `country`, `matches`, `run`, `highest_scores`, `hundreds`, `created_at`, `updated_at`) VALUES
(1,	10,	10,	'Deepak kumar',	'soni',	'xyz.html',	'india',	10,	1000,	89,	5,	'2019-09-26 19:02:15',	'2019-09-29 14:54:55'),
(2,	11,	1202,	'Steave',	'Smith',	'xyz.html',	'india',	100,	12000,	223,	9,	'2019-09-28 20:27:19',	'2019-09-29 15:02:19'),
(4,	10,	1002,	'Deepak',	'Soni',	NULL,	'india',	250,	10000,	245,	100,	'2019-09-29 13:24:19',	'2019-09-29 13:24:19');

DROP TABLE IF EXISTS `mt_team_master`;
CREATE TABLE `mt_team_master` (
  `team_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_uri` text COLLATE utf8_unicode_ci,
  `state` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mt_team_master` (`team_id`, `name`, `logo_uri`, `state`, `created_at`, `updated_at`) VALUES
(10,	'India',	'http://placehold.it/1500x550',	'',	'2014-07-22 14:15:21',	NULL),
(11,	'Australia',	'http://placehold.it/1500x550',	'',	'2014-07-22 14:15:21',	NULL),
(12,	'South Africa',	'http://placehold.it/1500x550',	'',	'2014-07-22 14:15:21',	NULL);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1,	'user',	NULL,	NULL),
(2,	'admin',	NULL,	NULL),
(3,	'superadmin',	NULL,	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `avatar`, `company`) VALUES
(1,	'Easter Stiedemann',	'deepak@gmail.com',	'498b5924adc469aa7b660f457e0fc7e5',	'BUVOJIUXJr',	'2019-09-24 15:25:36',	'2019-09-24 15:25:40',	'http://localhost/uploads/users/1d69e7715d1973e6fec04f2ff44ddffd81f722ac2bbaa0ad9ab4e97c4d686886.png',	'Ruecker-Zieme'),
(2,	'Jamaal Kulas',	'deron.beatty@example.net',	'$2y$10$fb/VBmizbMsgmXeZn2bB1uP1JFIK.xfHbc54IIJ8X.9x3/lCkC1CK',	'Hzt24wpYdA',	'2019-09-24 15:25:36',	'2019-09-24 15:25:43',	'http://localhost/uploads/users/ee2d5c48f9b0445f42e94896dc4e340e0ed57c113f1e7874c5677cfc4d7b3061.png',	'Klein-Reilly'),
(3,	'Carli Homenick',	'ora.beahan@example.net',	'$2y$10$0HyQfyi1uCFeAH5mDOSJk.RjCMik9MOQuyXSK6gHGL0zDWDH.RFWO',	'7mRErh0U7G',	'2019-09-24 15:25:36',	'2019-09-24 15:25:45',	'http://localhost/uploads/users/25cd23005967e873658c7e04b481bc51ad4f6928c4f589b80d62a16d254637fd.png',	'Bashirian Group'),
(4,	'Wilford Jacobi',	'hiram.weimann@example.org',	'$2y$10$ZIbE6uQY3noJU0sU3wtuAum55kKmPTymsu6.e.md5F5Magg5gqBii',	'ZXNMXZ6epu',	'2019-09-24 15:25:36',	'2019-09-24 15:25:48',	'http://localhost/uploads/users/43a49d1aba46f3f2a95cdd18726eba2f0c3eba16875dc0f50fa3b00f8058ae73.png',	'Mann, Swift and Kuhn'),
(5,	'Trystan Blanda',	'luettgen.dennis@example.org',	'$2y$10$fcjYuNqgIzG1ypjcPMrA2ut2hD6mhMZrh2mar1abK./TnEbyZl4m2',	'66GD9dDCDG',	'2019-09-24 15:25:36',	'2019-09-24 15:25:51',	'http://localhost/uploads/users/0f35276fd30114a47c43ad9d89d598f1b9bc19189e109c8e55598a7810a6ee8b.png',	'Bergstrom Ltd'),
(6,	'Miss Elissa Cummings',	'gerlach.kolby@example.org',	'$2y$10$JSVwZjbOg8ZigwZyv9Tc1eJPwmL6TJa3Ie9CwZCazQoQ4vrOckMd6',	'99d9yce7xO',	'2019-09-24 15:25:51',	'2019-09-24 15:25:53',	'http://localhost/uploads/users/56282aefe774545a9ad0f56d7c3c9fb548e722ab9e43ec269a8c46b3f0a289a7.png',	'Nader, Hirthe and Spencer'),
(7,	'Verda Gleichner',	'elinore08@example.com',	'$2y$10$SjryvveHMwOJrLW5dPgwg.jxnDFOhM1HmtcqO8b3qmL.kjuoaQ3UG',	'o7SxLtpsGB',	'2019-09-24 15:25:51',	'2019-09-24 15:25:56',	'http://localhost/uploads/users/7d3f34de67c614cb72f28e975a0665215a49c7203c6a1922333b94972dac4f4f.png',	'Swaniawski, Howe and Koepp'),
(8,	'Demo Admin',	'admin@admin.com',	'$2y$10$NqcuiBfpeNmv2wgeZX4Rwu8qFzkOLn9CyvCFSYKiQGR76S4pcHlxe',	'VChn6bzrDeQ4TLtxCbZgZ6xbgcbfQkS7NZ7hhIn4pyqiNJYeYDk2GiXpmDwb',	'2019-09-24 15:25:57',	'2019-09-29 16:57:07',	'http://localhost/uploads/users/5ebd96b9b44191ca0289ed850c1abebcdab8c5b0cd29b0c2f306829609ff5e6a.png',	'Kassulke, Bartell and Leannon'),
(9,	'Demo Student',	'student@student.com',	'$2y$10$00.GS1VCaPCHwUaJBni03.BWQBnNZB/g2Lfu9rKcrUXJFq0LOAn0W',	'MdNGDEJ0ac',	'2019-09-24 15:25:59',	'2019-09-24 15:26:00',	'http://localhost/uploads/users/fc589cd42e2e8244f05da502d7b0ddd8f8bacf763f040e666900e9a05871fed2.png',	'Corkery, Schimmel and Baumbach'),
(10,	'Armani Gaylord DVM',	'wcormier@example.org',	'$2y$10$XszPSyLdLcFGWcjBxCKEvuLC6v1w4vVGg/RNMTVfuMZ1vW3B10Ab6',	'RqcFMLCWhB',	'2019-09-25 13:13:15',	'2019-09-25 13:13:15',	'http://api.adorable.io/avatars/150/Armani+Gaylord+DVM',	'Bruen, Sporer and Walsh'),
(11,	'Eden Boyer',	'kuhlman.constantin@example.net',	'$2y$10$CO3oT/8z1z.3sAby/wJM1ujHtsAB7kn6Tx4mPinixt1TRbgi1uaq6',	'Ufbt1PuACj',	'2019-09-25 13:13:15',	'2019-09-25 13:13:15',	'http://api.adorable.io/avatars/150/Eden+Boyer',	'Paucek Group'),
(12,	'Prof. Dessie McCullough',	'jadyn16@example.org',	'$2y$10$6SmtlZRo9bvMWGAqmDh4G.e7NyCbSA51o1HqxXzKah7aQcgbpRNZa',	'f2sXoPuUQ9',	'2019-09-25 13:13:15',	'2019-09-25 13:13:15',	'http://api.adorable.io/avatars/150/Prof.+Dessie+McCullough',	'McLaughlin, Haag and Maggio'),
(13,	'Donato Bogisich',	'antwon.little@example.com',	'$2y$10$Ni8WnDXnxigRgSOLhTOYQuP8gNXsI2yKz0bTsFVCDNiuwxXO.YliC',	'stsM0TSq5S',	'2019-09-25 13:13:15',	'2019-09-25 13:13:15',	'http://api.adorable.io/avatars/150/Donato+Bogisich',	'Buckridge and Sons'),
(14,	'Rosalia Bechtelar',	'lucile34@example.org',	'$2y$10$nwP3c3hNwuJMTMxjAUmasexqhMn4L2cV5/.oysBrMTDHhLLOw2rre',	'e82aVJ8TJf',	'2019-09-25 13:13:16',	'2019-09-25 13:13:16',	'http://api.adorable.io/avatars/150/Rosalia+Bechtelar',	'Bayer LLC');

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_user_id_index` (`user_id`),
  KEY `user_role_role_id_index` (`role_id`),
  CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	NULL,	NULL),
(2,	2,	1,	NULL,	NULL),
(3,	3,	1,	NULL,	NULL),
(4,	4,	1,	NULL,	NULL),
(5,	5,	1,	NULL,	NULL),
(6,	6,	1,	NULL,	NULL),
(7,	7,	1,	NULL,	NULL),
(8,	8,	2,	NULL,	NULL),
(9,	8,	3,	NULL,	NULL),
(10,	8,	1,	NULL,	NULL),
(11,	9,	1,	NULL,	NULL);

-- 2019-09-30 16:55:50
