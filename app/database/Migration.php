<?php

require_once './Database.php';

class Migration {

    public static function migrate(){
        try {
            Database::getConnection()->query("CREATE TABLE IF NOT EXISTS `users` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `first_name` varchar(256) NOT NULL,
                `last_name` varchar(256) NOT NULL,
                `email` varchar(256) NOT NULL,
                `password` varchar(256) NOT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    
            Database::getConnection()->query("CREATE TABLE IF NOT EXISTS `expenses` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `category` int(11) NOT NULL DEFAULT 0,
                `description` text NOT NULL,
                `amount` bigint(20) NOT NULL DEFAULT 0,
                `image` varchar(256) DEFAULT NULL,
                `location` varchar(256) DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `user_id` bigint(20) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `fk_user_id` (`user_id`),
                CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

            echo "Database migrated successfully";
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}

Migration::migrate();
