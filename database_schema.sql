-- SQL Dump for Form Submissions Table
-- Generated for NXM Assessment 2023
-- Database: nxm_assessment_2023

-- Create form_submissions table
CREATE TABLE IF NOT EXISTS `form_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agree_to_terms` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_submissions_email_index` (`email`),
  KEY `form_submissions_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data (optional)
-- INSERT INTO `form_submissions` (`first_name`, `last_name`, `phone`, `email`, `agree_to_terms`, `created_at`, `updated_at`) VALUES
-- ('John', 'Doe', '+1234567890', 'john.doe@example.com', 1, NOW(), NOW());
