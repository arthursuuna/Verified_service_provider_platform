-- Service Provider System Database Setup
-- Run these commands in your MySQL database

-- Create service_categories table
CREATE TABLE IF NOT EXISTS `service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert specified service categories only
INSERT INTO `service_categories` (`name`, `description`, `icon`, `sort_order`, `is_active`) VALUES
('Plumbing', 'Water supply, drainage, pipe installation and repair services', '🔧', 1, 1),
('Surveying', 'Land surveying, property measurement, and mapping services', '📐', 2, 1),
('Construction', 'Building construction, renovation, and general contracting', '�️', 3, 1),
('Farming', 'Agricultural services, crop management, and livestock care', '🌾', 4, 1);

-- Create or update service_providers table with enhanced fields
CREATE TABLE IF NOT EXISTS `service_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(150) NOT NULL,
  `owner_name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `location` varchar(200) NOT NULL,
  `service_description` text NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `verification_documents` json DEFAULT NULL,
  `status` enum('Pending Verification','Verified','Suspended','Expired Subscription') DEFAULT 'Pending Verification',
  `is_subscribed` tinyint(1) DEFAULT 0,
  `subscription_expires_at` datetime DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `location` (`location`),
  KEY `is_subscribed` (`is_subscribed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create provider_service_categories junction table
CREATE TABLE IF NOT EXISTS `provider_service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_provider_id` int(11) NOT NULL,
  `service_category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provider_category` (`service_provider_id`, `service_category_id`),
  KEY `service_provider_id` (`service_provider_id`),
  KEY `service_category_id` (`service_category_id`),
  CONSTRAINT `fk_provider_categories_provider` FOREIGN KEY (`service_provider_id`) REFERENCES `service_providers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_provider_categories_category` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Display setup completion message
SELECT 'Service Provider System tables created successfully!' as status;