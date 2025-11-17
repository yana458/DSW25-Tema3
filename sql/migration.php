<?php
require_once '../bootstrap.php';

if (isset($argv[1])){
try{
//$sql = file_get_contents('sql/create_table_post.sql');
$sql = file_get_contents($argv[1]);
$pdo->exec($sql);
echo "SQL realizado con éxito";
} catch (Exception $e) {
    die("Error en la conficuración: ". $e->getMessage());
}
} else {
    echo "Falta el nombre del archivo a migrar";
}