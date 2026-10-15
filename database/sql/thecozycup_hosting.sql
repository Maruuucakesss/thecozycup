-- ============================================================================
--  The Cozy Cup: database schema for HOSTING (matches website update 9)
--  Works with Laravel 11 and 12 on MySQL 5.7+ / MariaDB 10.3+.
--
--  HOW TO USE (cPanel / phpMyAdmin):
--    1. Create an EMPTY database and a database user in your hosting panel,
--       and give the user ALL PRIVILEGES on it.
--    2. Open phpMyAdmin, click that database in the left sidebar, click Import,
--       choose this file, then click Import.
--
--  This file does not create or delete any database, and it does not drop tables.
--  Import it into an empty database. If a table already exists, the import stops
--  with an error instead of overwriting your data.
--
--  Default admin login:  admin@thecozycup.com  /  Admin@123
--  CHANGE THIS PASSWORD IMMEDIATELY after your first login (Admin > Password).
-- ============================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------------
--  Laravel framework tables
-- ---------------------------------------------------------------------------
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
--  The Cozy Cup tables
-- ---------------------------------------------------------------------------
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_drink` tinyint(1) NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `price_cold` decimal(8,2) DEFAULT NULL,
  `price_hot` decimal(8,2) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `grp` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price_add` decimal(8,2) NOT NULL DEFAULT 0.00,
  `is_multi` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `qty` int unsigned NOT NULL DEFAULT 1,
  `options_text` varchar(255) NOT NULL DEFAULT '',
  `unit_price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_user_id_foreign` (`user_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `total` decimal(9,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `contact_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `pickup_time` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_type` varchar(255) NOT NULL DEFAULT 'pickup',
  `delivery_address` text,
  `delivery_fee` decimal(8,2) NOT NULL DEFAULT 0.00,
  `reminded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `options_text` varchar(255) NOT NULL DEFAULT '',
  `qty` int unsigned NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(60) NOT NULL,
  `subject_type` varchar(40) DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  KEY `audit_logs_action_index` (`action`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
--  Starting data
-- ---------------------------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Admin', 'admin@thecozycup.com', '$2y$12$agM5JzoeVLmuCnObZBXDqexkNNfxP5HfWUv09p7xJaRdejJICh5ka', 'admin', NOW(), NOW());

INSERT INTO `categories` (`name`, `slug`) VALUES
('Coffee', 'coffee'), ('Non-Coffee', 'non-coffee'), ('Pastries', 'pastries');

INSERT INTO `products` (`category_id`, `name`, `description`, `is_drink`, `price`, `price_cold`, `price_hot`, `featured`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Americano - Unsweetened', 'Bold espresso and water, no sugar.',               1, 0, 80,  80,  0, 1, NOW(), NOW()),
(1, 'Americano - Sweetened',   'Espresso and water with a touch of sweetness.',      1, 0, 90,  90,  0, 1, NOW(), NOW()),
(1, 'Latte',                   'Smooth espresso with steamed milk.',                 1, 0, 100, 110, 0, 1, NOW(), NOW()),
(1, 'Caramel Macchiato',       'Vanilla, milk, espresso and caramel.',               1, 0, 130, 130, 1, 1, NOW(), NOW()),
(1, 'Dirty Matcha',            'Matcha latte topped with an espresso shot.',         1, 0, 130, 140, 0, 1, NOW(), NOW()),
(1, 'Seasalt Latte',           'Espresso latte with a salty-sweet cream top.',       1, 0, 120, 140, 1, 1, NOW(), NOW()),
(1, 'Spanish Latte',           'Espresso and milk sweetened with condensed milk.',   1, 0, 110, 120, 1, 1, NOW(), NOW()),
(1, 'Hazelnut Latte',          'Nutty hazelnut syrup in a creamy latte.',            1, 0, 110, 120, 0, 1, NOW(), NOW()),
(1, 'Vanilla Oat Latte',       'Vanilla and oat milk with espresso.',                1, 0, 130, 140, 0, 1, NOW(), NOW()),
(1, 'Mocha Latte',             'Espresso, chocolate and milk.',                      1, 0, 120, 140, 0, 1, NOW(), NOW()),
(2, 'Oat Matcha Latte',        'Ceremonial-style matcha with oat milk.',             1, 0, 140, 150, 0, 1, NOW(), NOW()),
(2, 'Matcha Latte',            'Earthy matcha with creamy milk.',                    1, 0, 120, 130, 1, 1, NOW(), NOW()),
(2, 'Seasalt Matcha',          'Matcha latte with a seasalt cream top.',             1, 0, 130, 140, 0, 1, NOW(), NOW()),
(3, 'Butter Croissant',        'Flaky and buttery, baked fresh.',                    0, 75, NULL, NULL, 0, 1, NOW(), NOW()),
(3, 'Chocolate Chip Cookie',   'Soft and chewy with melty chips.',                   0, 45, NULL, NULL, 0, 1, NOW(), NOW()),
(3, 'Banana Bread',            'Moist slice with ripe banana.',                      0, 60, NULL, NULL, 0, 1, NOW(), NOW()),
(3, 'Blueberry Muffin',        'Tender muffin with blueberries.',                    0, 70, NULL, NULL, 0, 1, NOW(), NOW()),
(3, 'Ensaymada',               'Soft sweet bun with butter and cheese.',             0, 55, NULL, NULL, 0, 1, NOW(), NOW()),
(3, 'Fudgy Brownie',           'Rich chocolate brownie square.',                     0, 65, NULL, NULL, 0, 1, NOW(), NOW());

INSERT INTO `options` (`grp`, `name`, `price_add`, `is_multi`, `sort`, `active`) VALUES
('Sugar level', 'Regular',         0,  0, 1, 1),
('Sugar level', 'Less sugar',      0,  0, 2, 1),
('Sugar level', 'No sugar',        0,  0, 3, 1),
('Extras',      'Extra shot',      30, 1, 4, 1),
('Extras',      'Oat milk',        30, 1, 5, 1),
('Extras',      'Vanilla syrup',   20, 1, 6, 1),
('Extras',      'Caramel drizzle', 20, 1, 7, 1);

INSERT INTO `settings` (`name`, `value`) VALUES ('delivery_fee', '50');

-- Tell Laravel these migrations already ran, so "php artisan migrate" will not try to run them again.
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2025_01_01_000000_create_shop_tables', 1),
('2025_01_02_000000_add_image_to_products_table', 1),
('2025_01_03_000000_add_delivery_and_audit_log', 1),
('2025_01_04_000000_create_settings_table', 1);
