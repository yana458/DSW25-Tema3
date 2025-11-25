<?php
namespace Dsw\Blog;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database 
{
    private static ?PDO $conn = null;

    // Patrón Singleton (Solo hay una instancia).
    public static function getConnection() : PDO {
        if (self::$conn) {
            return self::$conn;
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $host    = $_ENV['DB_HOST'] ?? '127.0.0.1';

$db      = $_ENV['DB_NAME'] ?? 'blog';
$user    = $_ENV['DB_USER'] ?? 'root';
$password    = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            self::$conn = new PDO($dsn, $user, $password, $options);
            return self::$conn;

        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}
