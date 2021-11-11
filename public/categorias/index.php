<?php
session_start();
require dirname(__DIR__, 2)."/vendor/autoload.php";
use source\Categorias;

(new Categorias)->generarCategorias(10); //Generamos Categorias
$categorias = (new Categorias)->readAll(); //Leemos la tabla entera
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Categorias</title>
</head>

<body style="background-color:silver">
    <h3 class="text-center">Categorias disponibles</h3>
    <div class="container mt-2">
        <a href="crcategoria.php" class="btn btn-info"><i class="fas fa-plus-circle"></i> Crear Categoria</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Detalles</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $categorias->fetch(PDO::FETCH_OBJ)) {
                    echo <<< TXT
                    <tr>
                        <th scope="row">bton Detalles</th>
                        <td>{$fila->id}</td>
                        <td>{$fila->nombre}</td>
                        <td>{$fila->descripcion}</td>
                        <td>botones</td>
                    </tr>
                    TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>