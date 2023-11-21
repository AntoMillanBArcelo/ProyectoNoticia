<?php
require '../db/DB.php';

$conexion = DB::obtenerConexion();
$stmt = $conexion->query('SELECT * FROM noticia');
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($noticias);
?>
