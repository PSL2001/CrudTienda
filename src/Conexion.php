<?php
namespace source;
use PDO;
use PDOException;
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
        //2. Guardamos los datos del fichero
        $host = $opciones['host'];
        $bbdd = $opciones['bbdd'];
        $user = $opciones['user'];
        $pass = $opciones['pass'];
        //3. Creamos el dns
        $dns = "mysql:host=$host;dbname=$bbdd;charset=utf8mb4";

        //4. Creamos la conexion
        try {
            self::$conexion = new PDO($dns, $user, $pass);
            //Añade esta linea solo si estas en desarrollo
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Error al conectar con la base de datos: ".$ex->getMessage());
        }
        
    }
}
