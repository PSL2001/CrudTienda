<?php
namespace source;

use Faker;
use PDOException;

class Categorias extends Conexion {
    private $id;
    private $nombre;
    private $descripcion;

    public function __construct() {
        parent::__construct(); //llamamos al constructor de la clase padre
    }

    //----------------------------------CRUD------------------------------
    public function create() {
        $q = "insert into categorias(nombre, descripcion) values(:n, :d)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nombre,
                ':d'=>$this->descripcion
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar la categoria: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }
    public function read() {

    }
    public function update() {

    }
    public function delete() {
        $q = "delete from categorias where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar la categoria: ".$ex->getMessage());
        }

        parent::$conexion = null;
    }
    //------------------------------Otros Metodos-------------------------
    public function generarCategorias($cant) {
        if ($this->hayCategorias() == 0) {
            //le decimos a faker de generar las categorias
            $faker = Faker\Factory::create("es_ES");
            for ($i=0; $i < $cant; $i++) { 
                $nombre = $faker->unique()->word();
                $descripcion = $faker->text();
                //Despues de generar los nombres, los seteamos y los creamos
                (new Categorias)->setNombre($nombre)
                ->setDescripcion($descripcion)
                ->create();
            }
        }
    }

    public function hayCategorias() {
        $q = "select * from categorias";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay categorias: ".$ex->getMessage());
        }
        parent::$conexion = null; //Cerramos la conexion
        return $stmt->rowCount(); //rowCount devuelve el numero de filas del query
    }

    public function readAll() {
        $q = "select * from categorias order by nombre";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer todas las categorias: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }
    public function existeCategoria($nom) {
        $q = "select * from categorias where nombre = :n";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$nom
            ]);
        } catch (PDOException $ex) {
            die("Error al leer todas las categorias: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;

    }
    //-------------------------------Getters y setters---------------------
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}