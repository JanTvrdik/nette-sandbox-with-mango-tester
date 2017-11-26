CREATE TABLE `users` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	`password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	`email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	`role` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
