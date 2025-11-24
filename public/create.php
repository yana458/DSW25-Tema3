<?php
$titulo ="Formulario para crear un usuario";
include '../includes/header.php';
?>
    <form action="store.php" method="post">
        <p>
            <label for="name">Nombre: </label>
            <input type="text" name="name" id="name" required>
        </p>
        <p>
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>
        </p>
        <p>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </p>
        <p>
            <p>Tipo usuario: </p>
            <label>
                <input type="radio" name="role" value="user" checked> usuario
            </label>
            <label>
                <input type="radio" name="role" value="admin"> administrador
            </label>
        </p>
        <p>
            <button type="submit">Crear</button>
        </p>
    </form>
<?php
include '../includes/footer.php';
?>