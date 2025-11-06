-- Migration to create the cms_pages table
-- Run this once in your `ns_coffee` database via phpMyAdmin or any other SQL client.

CREATE TABLE IF NOT EXISTS `cms_pages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `title` VARCHAR(255) NOT NULL,
  `content_html` TEXT,
  `image` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;