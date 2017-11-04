-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2017 at 02:38 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `LaravelDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `content`, `user_id`, `question_id`, `created_at`, `updated_at`) VALUES
(1, '本来就可爱啊[手动微笑]', 3, 1, '2017-10-27 23:07:12', '2017-10-27 23:17:09'),
(2, '大家都很可爱', 2, 1, '2017-10-26 16:00:00', '2017-10-27 16:00:00'),
(3, '你会发现比你聪明的人比你还努力', 2, 2, '2017-10-26 16:00:00', '2017-10-27 16:00:00'),
(4, '光耀门楣', 4, 2, '2017-10-27 16:00:00', '2017-10-27 16:00:00'),
(5, '这个我还真不知道！！', 6, 3, '2017-11-29 16:00:00', '2017-11-29 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `answer_user`
--

CREATE TABLE `answer_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `answer_id` int(10) UNSIGNED NOT NULL,
  `vote` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer_user`
--

INSERT INTO `answer_user` (`id`, `user_id`, `answer_id`, `vote`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, '2017-10-28 03:46:50', '2017-10-28 03:46:50'),
(2, 3, 2, 2, '2017-10-28 03:47:54', '2017-10-28 03:47:54'),
(28, 9, 4, 1, '2017-10-31 01:18:48', '2017-10-31 01:18:48'),
(29, 9, 1, 1, '2017-10-31 01:19:17', '2017-10-31 01:19:17'),
(40, 10, 1, 1, '2017-10-31 01:54:47', '2017-10-31 01:54:47'),
(41, 10, 3, 2, '2017-10-31 02:08:48', '2017-10-31 02:08:48'),
(42, 10, 2, 1, '2017-10-31 02:08:51', '2017-10-31 02:08:51'),
(79, 6, 1, 2, '2017-11-01 03:43:18', '2017-11-01 03:43:18'),
(80, 6, 5, 2, '2017-11-01 03:44:20', '2017-11-01 03:44:20'),
(84, 5, 5, 1, '2017-11-01 19:19:11', '2017-11-01 19:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED DEFAULT NULL,
  `answer_id` int(10) UNSIGNED DEFAULT NULL,
  `reply_to` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `user_id`, `question_id`, `answer_id`, `reply_to`, `created_at`, `updated_at`) VALUES
(2, 'shafaddd', 3, NULL, 1, NULL, '2017-10-28 00:49:48', '2017-10-28 00:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2017_10_27_061728_create_table_users', 1),
(5, '2017_10_28_022652_create_table_questions', 2),
(6, '2017_10_28_063357_create_table_answers', 2),
(7, '2017_10_28_080300_create_table_comments', 3),
(9, '2017_10_28_091723_create_table_answer_user', 4),
(11, '2017_10_28_162743_add_field_phone_captcha', 5);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci COMMENT 'description',
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ok',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `desc`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '为什么这么可爱', '给出你的回答', 3, 'ok', '2017-10-18 16:00:00', '2017-10-21 16:00:00'),
(2, '考上清华是一种怎样的体验？', '分享一下你们的感受吧', 1, 'ok', '2017-10-03 16:00:00', '2017-10-09 16:00:00'),
(3, '客户端通信如何加密并且防抓包？', 'https还是可以在安装了证书之后抓包看到的，有一种方式是绑定服务端证书，但是存在证书过期、更换等问题，更新比较麻烦。不知道支付宝、微信这些是怎么做的，可否有大神解答一下？', 4, 'ok', '2017-09-30 16:00:00', '2017-10-26 16:00:00'),
(6, 'tst1', NULL, 5, 'ok', '2017-10-30 00:09:37', '2017-10-30 00:09:37'),
(7, '如何评价广州恒大七连冠？', '今晚，广州恒大实现七星连珠，豪取七连冠，广州恒大为什么可以延续辉煌？这对中国足球又有什么益处和弊端呢？', 5, 'ok', '2017-10-30 00:11:19', '2017-10-30 00:11:19'),
(8, '你的收入能让你过怎样的生活？', '2015年，有过一次收入情况调查。\n双职工家庭年收入十万元，已经超过了，中国百分之七十人口的收入。\n换而言之，一月稳定工资四千。已经是中国为数不多的百分之三十高收入人群了。\n那些占着房躺着地，月入上万的人，还不停在下面卖惨。真是这个时代的特色。', 5, 'ok', '2017-10-30 00:14:34', '2017-10-30 00:14:34'),
(9, '现代医学已经发展到了什么恐怖的水平？', '现代医学已经发达到很多患者家属认为无论得了什么病只要死在医院了就应该赔钱的超现实的程度', 6, 'ok', '2017-10-31 22:07:39', '2017-10-31 22:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone_captcha` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `avatar_url`, `phone`, `password`, `intro`, `created_at`, `updated_at`, `phone_captcha`) VALUES
(1, '韩梅梅', '123456', NULL, NULL, '', '任他凡事清浊，为你一笑间轮回甘堕', NULL, NULL, ''),
(2, '韩梅梅1', NULL, NULL, NULL, '$2y$10$/8sCPhIH/jctFgCOMT0NUeB2FjvJwXllp7Jpg5.nOyqoHDKK9AxfS', '寄君一曲，不问曲终人聚散', '2017-10-26 23:59:41', '2017-10-26 23:59:41', ''),
(3, 'xiaoming', NULL, NULL, '135817', '$2y$10$pLriUjltE4gwSgFhyb9m0uPBycZlt2fvvpQ7qpuFo8uSEhJRSFVKq', '用我三生烟火，换你一世迷离', '2017-10-27 19:04:55', '2017-10-28 08:56:44', '8137'),
(4, 'xiaohong', NULL, NULL, NULL, '$2y$10$nOHwLYfFJgrujlV2UMEDHOJRis6U9AA0SE1PemJ6dHQw1Q.pBF9dW', '待浮花浪蕊俱尽', '2017-10-28 04:21:34', '2017-10-28 07:53:03', ''),
(5, 'xiaohei', NULL, NULL, NULL, '$2y$10$Mzv/V4ImaI/woSRWFH99veboKY7vABwiUPRaROk95C/pu.CtTbM8q', '乌云蔽月，人迹踪绝', '2017-10-29 19:40:50', '2017-10-29 19:40:50', ''),
(6, 'xiaobai', NULL, NULL, NULL, '$2y$10$znEjMOMRh5Ok4E1iTmleD.ISYpTH1n0S2n3UqYXCOTNASeg8xhvH2', '山河拱手，为君一笑', '2017-10-29 19:46:39', '2017-10-29 19:46:39', ''),
(7, 'xiaolan', NULL, NULL, NULL, '$2y$10$pnGkrelTljOCkbvT9rYj6.1O19Fd3w6uj6irRzyfrYo/miTx6B04C', '几段唏嘘几世悲欢', '2017-10-29 21:53:15', '2017-10-29 21:53:15', ''),
(8, 'xiaodi', NULL, NULL, NULL, '$2y$10$fGZJNFbI.euz5y4Y2EAX6epGdc7Y4i4edaFvSOjqYwxU2gKiTFT4m', '梦回曲水边', '2017-10-29 22:43:16', '2017-10-29 22:43:16', ''),
(9, 'xiaoxiaoniao', NULL, NULL, NULL, '$2y$10$f3neou9qdq0fiU.TPApPueBErqY/DcFhEY8jhLP7Efo60yoFXJd4.', NULL, '2017-10-30 22:03:43', '2017-10-30 22:03:43', ''),
(10, 'shuaihu', NULL, NULL, NULL, '$2y$10$ZOoWtshPyS2koP5s1xeIg./4gF20/Luh6WZ8bG8Ot9UA4.VabTde6', NULL, '2017-10-31 01:19:49', '2017-10-31 01:19:49', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_user_id_foreign` (`user_id`),
  ADD KEY `answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `answer_user`
--
ALTER TABLE `answer_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `answer_user_user_id_answer_id_vote_unique` (`user_id`,`answer_id`,`vote`),
  ADD KEY `answer_user_answer_id_foreign` (`answer_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_question_id_foreign` (`question_id`),
  ADD KEY `comments_answer_id_foreign` (`answer_id`),
  ADD KEY `comments_reply_to_foreign` (`reply_to`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `answer_user`
--
ALTER TABLE `answer_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `answer_user`
--
ALTER TABLE `answer_user`
  ADD CONSTRAINT `answer_user_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `answer_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `comments_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `comments_reply_to_foreign` FOREIGN KEY (`reply_to`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
