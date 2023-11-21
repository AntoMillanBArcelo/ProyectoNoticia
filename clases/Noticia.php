<?php

class Noticia {
    private $id;
    private $fechaIni;
    private $fechaFin;
    private $titulo;
    private $prioridad;
    private $duracion;
    private $tipoUrl;
    private $url;
    private $perfil;

    public function __construct($fechaIni, $fechaFin, $titulo, $prioridad, $duracion, $tipoUrl, $url, $perfil) {
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->titulo = $titulo;
        $this->prioridad = $prioridad;
        $this->duracion = $duracion;
        $this->tipoUrl = $tipoUrl;
        $this->url = $url;
        $this->perfil = $perfil;
    }

    // Getters y Setters (puedes generarlos automáticamente en muchos IDEs)
    // ...

    
    public function toArray() {
        return [
            'id' => $this->id,
            'fecha_ini' => $this->fechaIni,
            'fecha_fin' => $this->fechaFin,
            'titulo' => $this->titulo,
            'prioridad' => $this->prioridad,
            'duracion' => $this->duracion,
            'tipoUrl' => $this->tipoUrl,
            'url' => $this->url,
            'perfil' => $this->perfil,
        ];
    }
}
?>
