<?php

/**
 * Configuration of database connection
 * implemented using Singleton design pattern
 */
class Database
{

    private static $instance;
    private static $connection;

    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "pure";

    private function __construct()
    {
        try {
            $conn = "mysql:host=$this->hostname;dbname=$this->dbname";
            self::$connection = new PDO($conn, $this->username, $this->password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getConnection()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$connection;
    }

    public static function prepare(string $query)
    {
        return self::getConnection()->prepare($query);
    }
}
