<?php

/**
 * Configuration of database connection
 * implemented using Singleton design pattern
 */
class Database {

    private static $instance;
    private static $connection;

    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "e";
    
    private function __construct()
    {
        self::$connection = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

        if (self::$connection->connect_error) {
            die ("Connection failed: " . self::$connection->connect_error);
        }
    }

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$connection;
    }

    public static function query(string $query) {
        return self::getConnection()->query($query);
    }

    public static function prepare(string $query) {
        return self::getConnection()->prepare($query);
    }
}
