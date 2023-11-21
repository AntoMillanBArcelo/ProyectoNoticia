<?php
    class Db
    {
        private static $conexion = null;
        
        public static function obtenerConexion() 
        {
            if (self::$conexion === null) 
            {
                self::$conexion = new PDO('mysql:host=localhost;dbname=noticia', 'root', '');
            }
            return self::$conexion;
        }
    }
?>    
