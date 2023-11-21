<?php
require 'db/DB.php';

// Ruta donde se guardarán los archivos multimedia
$rutaMultimedia = 'multimedia/';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) 
{
    // Obtener los datos del formulario
    $fechaIni = $_POST['fecha_ini'];
    $fechaFin = $_POST['fecha_fin'];
    $titulo = $_POST['titulo'];
    $prioridad = $_POST['prioridad'];
    $duracion = $_POST['duracion'];
    $contenido = $_POST['contenido'];
    $tipoUrl = $_POST['tipo_url'];
    $perfil = $_POST['perfil'];
    $url = $_POST['url'];

    // Manejo de archivo si el tipoUrl es 'foto' o 'video'
    $archivo = null;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) 
    {
        // Obtener la extensión del archivo
        $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        
        // Generar un nombre único para el archivo
        $nombreArchivo = uniqid('archivo_') . '.' . $extension;

        // Determinar la carpeta de destino
        $carpetaDestino = ($tipoUrl === 'foto') ? $rutaMultimedia . 'fotos/' : $rutaMultimedia . 'videos/';

        // Ruta completa del archivo de destino
        $rutaCompleta = $carpetaDestino . $nombreArchivo;

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaCompleta)) 
        {
            echo 'Archivo subido con éxito.';
        } 
        else 
        {
            echo 'Error al subir el archivo. Verifica los permisos de la carpeta y la configuración de PHP.';
        }
        

        // Guardar la URL en la base de datos
        $url = $rutaCompleta;
    }

    // Insertar la noticia en la base de datos
    $conexion = DB::obtenerConexion();
    $stmt = $conexion->prepare('INSERT INTO noticia (fecha_ini, fecha_fin, titulo, prioridad, duracion, contenido, tipoUrl, perfil, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$fechaIni, $fechaFin, $titulo, $prioridad, $duracion, $contenido, $tipoUrl, $perfil, $url]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia</title>
    <link rel="stylesheet" href="css/crudnoticia.css">
    <script>
        function mostrarOcultarContenido() 
        {
            var tipoContenido = document.getElementById('tipo_contenido');
            var textareaContenido = document.getElementById('textarea_contenido');
            var fileInput = document.getElementById('file_input');
            var formatosVideo = document.getElementById('formatos_video');

            textareaContenido.style.display = (tipoContenido.value === 'web') ? 'block' : 'none';
            fileInput.style.display = (tipoContenido.value === 'foto' || tipoContenido.value === 'video') ? 'block' : 'none';
            formatosVideo.style.display = (tipoContenido.value === 'video') ? 'block' : 'none';

            if (tipoContenido.value === 'video') {
                fileInput.setAttribute('accept', 'video/*');
            } else if (tipoContenido.value === 'foto') {
                fileInput.setAttribute('accept', 'image/*');
            }
        }
    </script>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
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

        <label for="url">Url:</label>
        <input type="text" name="url" required><br>

        <label for="perfil">Perfil:</label>
        <select name="perfil">
            <option value="alumno">Alumno</option>
            <option value="profesor">Profesor</option>
            <option value="todos">Todos</option>
        </select><br>

        <label for="tipo_url">Tipo de contenido:</label>
        <select name="tipo_url" id="tipo_contenido" onchange="mostrarOcultarContenido()">
            <option value="web">Web</option>
            <option value="video">Video</option>
            <option value="foto">Foto</option>
        </select><br>

        <!-- Mostrar textarea solo si se selecciona 'web' -->
        <div id="textarea_contenido" style="display: none;">
            <label for="contenido">Contenido:</label>
            <textarea name="contenido" ></textarea><br>
        </div>

        <!-- Mostrar input file y checkbox solo si se selecciona 'video' o 'foto' -->
        <div id="file_input" style="display: none;">
            <label for="archivo">Archivo:</label>
            <input type="file" name="archivo" id="archivo" accept=""><br>

            <!-- Mostrar checkboxes solo si se selecciona 'video' -->
            <div id="formatos_video" style="display: none;">
                <label for="formatos_video">Formatos de video permitidos:</label>
                <input type="checkbox" name="formatos_video[]" value="mp4"> MP4
                <input type="checkbox" name="formatos_video[]" value="avi"> AVI
                <input type="checkbox" name="formatos_video[]" value="mkv"> MKV<br>
            </div>
        </div>

        <input type="submit" name="enviar" value="Crear Noticia">
    </form>
</body>
</html>
