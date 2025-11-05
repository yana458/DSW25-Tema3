<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Formulario para cerar un usuario</h1>
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
</body>
</html>