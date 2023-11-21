<?php

class NoticiaRepository {
    private $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function guardarNoticia(Noticia $noticia) {
        $stmt = $this->conexion->prepare('INSERT INTO noticia (fecha_ini, fecha_fin, titulo, prioridad, duracion, tipoUrl, url, perfil) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $noticia->getFechaIni(),
            $noticia->getFechaFin(),
            $noticia->getTitulo(),
            $noticia->getPrioridad(),
            $noticia->getDuracion(),
            $noticia->getTipoUrl(),
            $noticia->getUrl(),
            $noticia->getPerfil(),
        ]);

        return $this->conexion->lastInsertId();
    }

    public function obtenerNoticiaPorId($id) {
        $stmt = $this->conexion->prepare('SELECT * FROM noticia WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Otros métodos para actualizar, eliminar, obtener todas las noticias, etc.
}

// Uso del repositorio:
// $pdo = new PDO('mysql:host=127.0.0.1;dbname=noticia', 'usuario', 'contraseña');
// $noticiaRepository = new NoticiaRepository($pdo);
// $noticia = new Noticia(/* ... */);
// $noticiaId = $noticiaRepository->guardarNoticia($noticia);
// $noticiaRecuperada = $noticiaRepository->obtenerNoticiaPorId($noticiaId);

?>
