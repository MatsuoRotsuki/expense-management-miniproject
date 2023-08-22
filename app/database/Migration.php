<?php

require_once 'app/database/Database.php';
require_once 'app/models/User.php';
require_once 'app/models/Expense.php';

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

    public static function seed()
    {
        try {
            for ($i = 0; $i < 100; $i++) {
                Expense::create([
                    'category' => random_int(1, 12),
                    'description' => str_shuffle("ABCDEFGHIJKLMNOPQ"),
                    'amount' => random_int(10000, 100000),
                    'location' => 'Hanoi',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'user_id' => 1,
                ]);
            }
        } catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}