<?php

use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

if(($_SERVER['REQUEST_METHOD'] === "POST") && isset($_POST['name'], $_POST['password'])){
    $userDAO = new UserDAO($conn);
    $user = $userDAO->login($_POST['name'], $_POST['password']);

    if($user){
        $_SESSION['user_id'] = $user->getId();
        header('Location: /');
        exit();
    } else {
        $error= "Error en el usuario o la contraseña";
    }
}

$titulo = "Acceso de usuario";
include '../includes/header.php';

if($isset($error)){
    printf('<p class="error">%s</p>', $error);
}
?>
<form action="login.php" method="post">
    <p>
        <input type="text" name="name" id="name" placeholder="Usuario..">
    </p>
    <p>
        <input type="password" name="password" id="password" placeholder="Contraseña...">
    </p>
    <p>
        <button type="submit">Enviar</button>
    </p>
</form>
<?php
include '../includes/footer.php';
?>