<?php
// Pagina de prueba paea ver todas las variables de entorno. Se debe eliminar en produccion
use Dotenv\Dotenv;

require_once '../vendor/autoload.php';

//Leer variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
//password = '1234';  -- arroja error del catch
$charset = $_ENV['DB_CHARSET'];

//Hacer la conexion a la BD
//Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try{
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e){
    echo "<h1>Error en la conexión</h1>";
    printf("<p>%s</p>", $e->getMessage());
    die();
}

//echo "Conexión correcta";

//Consulta SQL o manipulación de la base de datos

//Usuario por ID.
$userId = '2';

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
            printf('<td><a href="delete.php?id=%s">Eliminar</td>',
                $user['id']
        );
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
