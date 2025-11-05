<?php
//Modificar un usuario

require_once '../vendor/autoload.php';
require_once 'conexion.php';

if(isset($_POST['id'], $_POST['name'], $_POST['email'])){

$sql = "UPDATE users SET name= :name, email = :email WHERE id= :id";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'email' => $_POST['email']
]);
}

header('Location: selectall.php');
exit();