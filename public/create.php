<?php
$titulo = "Formulario para cerar un usuario";
include '../includes/header.php';
?>
<form action=store.php method="post">
    <p>
        <label for=name> Nombre: </label>
        <input type="text" name="name" id="name" required>
    </p>

    <p>
        <label for=email> Correo electrónico: </label>
        <input type="email" name="email" id="email" required>
    </p>

    <p>
        <button type="submit">Crear</button>
    </p>

</form>

<?php
include '../includes/footer.php';
?>