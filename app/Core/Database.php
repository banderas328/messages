<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO('sqlite:' . __DIR__ . '/../../data/database.sqlite');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("DB connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
