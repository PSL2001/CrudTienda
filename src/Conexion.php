<?php
class Conexion {
    protected static $conexion;

    public function __construct() {
        //Si la conexion es nula, llamamos al metodo crearConexion
        if (self::$conexion == null) {
            self::crearConexion();
        }
    }

    public static function crearConexion() {
        //1. Leemos el archivo .conf
        $fichero = dirname(__DIR__, 1)."/.conf";
        $opciones = parse_ini_file($fichero);
    }
}