<?php
namespace Dsw\Blog;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $conn = null;
    //Patron SIngleton (solo hay una instancia)
    public static function getConnection(): PDO {
        if(self::$conn) {
            return self::$conn;
        }
        
        $dotenv = Dotenv::createImmutable(__DIR__.'/..');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $charset = $_ENV['DB_CHARSET'];

        //Hacer la conexion a la BD
        //Data Source Name (DSN)
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try{
            self::$conn = new PDO($dsn, $user, $password, $options);
            return self::$conn;
        } catch (PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }
}