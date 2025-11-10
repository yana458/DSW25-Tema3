<?php
// Tabla con todos los usuarios
use Dsw\Blog\Database;
use Dotenv\Dotenv;

require_once '../vendor/autoload.php';
require_once 'conexion.php';

//Patron singleton, se crea solo una conexion  por muchas veces que se intente conectar siempre será la misma conexion
try{
    $pdo = Database::getConnection();
}catch (PDOException $e) {
    die("Error al concetra la BD: ". $e->getMessage());
}

//Consulta SQL o manipulación de la base de datos

$sql = "SELECT id, name, email, register_date FROM users";
$stmt = $pdo->prepare($sql);

$stmt->execute();

$users = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
        td, th {
            border: 1px solid pink;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
    <p>
        <a href='create.php'>Crear usuario</a>
    </p>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($users as $user){
                echo "<tr>";
            printf('<td>%s</td><td>%s</td><td>%s</td><td>%s</td>', 
                $user['id'],
                $user['name'],
                $user['email'],
                $user['register_date']
            );
            echo "<td>";
               printf('<a href="edit.php?id=%s">Editar &#9948; </a> | ',
                $user['id']
        );
            printf('<a href="delete.php?id=%s">Eliminar </a>',
                $user['id']
        );
            echo "</td>";
            echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
//Desconexión
$stmt = null;
$pdo = null;
