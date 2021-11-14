<?php
namespace source;

use Faker;
use PDO;
use PDOException;

class Articulos extends Conexion {
    private $id;
    private $nombre;
    private $precio;
    private $categoria_id;


    //------------------CRUD---------------------
    public function create() {
        $q = "insert into articulos (nombre, precio, categoria_id) values(:n, :p, :c)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nombre,
                ':p'=>$this->precio,
                ':c'=>$this->categoria_id
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar articulo: ".$ex->getMessage());
        }
        parent::$conexion = null;

    }
    public function read($id) {
        $q = "select * from articulos where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch (PDOException $ex) {
            die("Error al leer la categoria: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ); //Esto siempre devuelve una fila
    }
    public function update() {
        $q = "update articulos set nombre=:n, precio=:p, categoria_id=:c where id=:i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n'=>$this->nombre,
                ':p'=>$this->precio,
                ':c'=>$this->categoria_id,
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar el articulo ".$ex->getMessage());
        }
        parent::$conexion == null;
    }
    public function delete() {
        $q = "delete from articulos where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i'=>$this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el articulo: ".$ex->getMessage());
        }

        parent::$conexion = null;
    }

    //---------------Otros Metodos-------------
    public function generarArticulos($cant) {
        if ($this->hayArticulos() == 0) {
            # Si nos devuelven 0 filas, entonces es que no hay articulos
            $faker = Faker\Factory::create('es_ES');
            //necesitamos los id's de las categorias
            $categorias = (new Categorias)->devolverID();
            for ($i=0; $i < $cant; $i++) { 
                $nombre = $faker->word();
                $precio = $faker->randomFloat(2, 0, 99999.99);
                $categoria_id = $categorias[array_rand($categorias, 1)]; //como devolvemos todo en un array, podemos usar array_rand y coger de $categorias una posicion aleatoria

                (new Articulos)->setNombre($nombre)
                ->setPrecio($precio)
                ->setCategoria_id($categoria_id)
                ->create();
            }
        }
    }
    public function hayArticulos() {
        $q = "select * from articulos";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay articulos: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public function ReadAll() {
        $q = "select * from articulos order by precio";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al mostrar todos los articulos: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }

    public function devolverArticulos() {
        $q = "select id, nombre, categoria_id from articulos order by nombre";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver los articulos: ".$ex->getMessage());
        }
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    //-----------------------------------------
    /**
     * Get the value of categoria_id
     */ 
    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    /**
     * Set the value of categoria_id
     *
     * @return  self
     */ 
    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

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
}