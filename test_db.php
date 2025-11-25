<?php
require __DIR__ . '/vendor/autoload.php';

use Dsw\Blog\Database;

try {
    $pdo = Database::getConnection();
    echo "OK: conectado a la base de datos.\n";
} catch (PDOException $e) {
    echo "ERROR de conexión con BD: " . $e->getMessage() . "\n";
    exit(1);
}
