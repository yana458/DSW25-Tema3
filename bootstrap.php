<?php
session_start();
//archivo para inicializar el programa

use Dsw\Blog\DAO\UserDAO;
use Dsw\Blog\Database;
require_once '../vendor/autoload.php';

try {
    $conn = Database::getConnection();
} catch (Exception $e) {
    die('Error de conexion con BD: ' . $e->getMessage());
}

$user = null;//nulo si no hay ussario identificado, luego se sobreescribe
if(isset($_SESSION['user_id'])){
    $userDAO = new UserDAO($conn);
    $user = $userDAO->get($_SESSION['user_id']);
}