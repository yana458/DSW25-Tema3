<?php

use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

// if(isset($_GET['id'])){
//     $id =$_GET['id'];
//     //Busco en la base de datos el ususario con ese id

//     $sql = "SELECT id, name, email FROM users WHERE id = :id";
//     $stmt =$pdo->prepare($sql);
//     $stmt->execute(['id' => $id]);

//     $user = $stmt->fetch();
// } 

// if(!isset($_GET['id']) || !$user){
//     echo "Id no encontrado";
//     exit();
// }

$id = $_GET['id'];

$userDAO = new UserDAO($conn);
$user = $userDAO->get($id);

if(!$user){
    die("Usuario no encontrado");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Formulario para modificar usuario con id = <?php echo $id; ?></h1>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <p>
            <label for=name> Nombre: </label>
            <input type="text" name="name" id="name" required value="<?= $user->getName()?>">
        </p>

         <p>
            <label for=email> Correo electrónico: </label>
            <input type="email" name="email" id="email" required value="<?= $user->getEmail()?>">
        </p>

        <p>
            <button type="submit">Modificar</button>
        </p>

    </form>
</body>
</html>