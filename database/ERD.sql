CREATE TABLE `buildings` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `building_code` varchar(20) UNIQUE,
  `name` varchar(100),
  `description` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `rooms` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `room_code` varchar(20) UNIQUE,
  `building_id` int,
  `name` varchar(100),
  `description` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `assets` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `asset_code` varchar(50) UNIQUE,
  `name` varchar(150),
  `category_id` int,
  `room_id` int,
  `status` varchar(20),
  `owner` varchar(100),
  `purchase_date` date,
  `value` decimal,
  `last_update` datetime,
  `notes` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `asset_categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100),
  `description` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `asset_damage_reports` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `asset_id` int,
  `reported_by` varchar(100),
  `report_date` datetime,
  `severity` varchar(20),
  `description` text,
  `status` varchar(20),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `maintenance_schedules` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `asset_id` int,
  `scheduled_date` date,
  `frequency` varchar(20),
  `description` text,
  `assigned_to` varchar(100),
  `status` varchar(20),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `maintenance_logs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `schedule_id` int,
  `asset_id` int,
  `performed_by` varchar(100),
  `date_performed` datetime,
  `result` text,
  `next_recommendation_date` date,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `asset_status_history` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `asset_id` int,
  `previous_room_id` int,
  `new_room_id` int,
  `previous_status` varchar(20),
  `new_status` varchar(20),
  `changed_by` varchar(100),
  `change_date` datetime,
  `notes` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100),
  `email` varchar(100) UNIQUE,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) UNIQUE,
  `description` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `permissions` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) UNIQUE,
  `description` text,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `role_permissions` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role_id` int,
  `permission_id` int,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `user_roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `role_id` int,
  `created_at` datetime,
  `updated_at` datetime
);

ALTER TABLE `rooms` ADD FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`);

ALTER TABLE `assets` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

ALTER TABLE `assets` ADD FOREIGN KEY (`category_id`) REFERENCES `asset_categories` (`id`);

ALTER TABLE `asset_damage_reports` ADD FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

ALTER TABLE `maintenance_schedules` ADD FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

ALTER TABLE `maintenance_logs` ADD FOREIGN KEY (`schedule_id`) REFERENCES `maintenance_schedules` (`id`);

ALTER TABLE `maintenance_logs` ADD FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

ALTER TABLE `asset_status_history` ADD FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

ALTER TABLE `asset_status_history` ADD FOREIGN KEY (`previous_room_id`) REFERENCES `rooms` (`id`);

ALTER TABLE `asset_status_history` ADD FOREIGN KEY (`new_room_id`) REFERENCES `rooms` (`id`);

ALTER TABLE `user_roles` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `user_roles` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `role_permissions` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `role_permissions` ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);
