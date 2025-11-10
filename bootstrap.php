<?php
//archivo para inicializar el programa
use Dsw\Blog\Database;
require_once '../vendor/autoload.php';

try {
    $conn = Database::getConnection();
} catch (Exception $e) {
    die('Error de conexion con BD: ' . $e->getMessage());
}