<?php
require 'db/DB.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    // Obtener los datos del formulario
    $fechaIni = $_POST['fecha_ini'];
    $fechaFin = $_POST['fecha_fin'];
    $titulo = $_POST['titulo'];
    $prioridad = $_POST['prioridad'];
    $duracion = $_POST['duracion'];
    $contenido = $_POST['contenido'];
    $tipoUrl = $_POST['tipo_url'];

    // Validar y procesar los datos (puedes agregar más validaciones según tus necesidades)

    // Insertar la noticia en la base de datos
    $conexion = DB::obtenerConexion();
    $stmt = $conexion->prepare('INSERT INTO noticia (fecha_ini, fecha_fin, titulo, prioridad, duracion, contenido, tipoUrl) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$fechaIni, $fechaFin, $titulo, $prioridad, $duracion, $contenido, $tipoUrl]);

    // Redirigir o mostrar un mensaje de éxito
    header('Location: index.php'); // Puedes redirigir a otra página si lo deseas
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia</title>
</head>
<body>
    <h2>Crear Noticia</h2>
    <form action="" method="post">
        <label for="fecha_ini">Fecha inicio:</label>
        <input type="date" name="fecha_ini" required><br>

        <label for="fecha_fin">Fecha fin:</label>
        <input type="date" name="fecha_fin" required><br>

        <label for="titulo">Enunciado:</label>
        <input type="text" name="titulo" required><br>

        <label for="prioridad">Prioridad:</label>
        <select name="prioridad" required>
            <option value="poco">Poca importancia</option>
            <option value="medio">Importancia media</option>
            <option value="mucho">Mucha importancia</option>
        </select><br>

        <label for="duracion">Visibilidad:</label>
        <input type="time" name="duracion" required><br>

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" required></textarea><br>

        <label for="tipo_url">Tipo de URL:</label>
        <select name="tipo_url" required>
            <option value="foto">Foto</option>
            <option value="video">Video</option>
        </select><br>

        <input type="submit" name="enviar" value="Crear Noticia">
    </form>
</body>
</html>
