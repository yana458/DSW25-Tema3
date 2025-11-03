<?php
// Pagina de prueba paea ver todas las variables de entorno. Se debe eliminar en produccion
use Dotenv\Dotenv;

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

echo "<pre>";
print_r(($_ENV));
echo "</pre>";

//Mostrar variable
printf('Base de datos: %s', $_ENV['DB_NAME']);