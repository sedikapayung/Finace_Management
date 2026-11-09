<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ? PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $host = Env::get('DB_HOST', '127.0.0.1');
            $port = Env::get('DB_PORT', '5432');
            $dbname = Env::get('DB_NAME', 'finance_management');
            $user = Env::get('DB_USER', 'postgres');
            $password = Env::get('DB_PASSWORD', '');

            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

            try {
                self::$connection = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die("Koneksi Database Gagal: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
?>