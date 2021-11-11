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
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo <<< TXT1
            <div class="alert alert-success" role="alert">
                {$_SESSION['mensaje']}
            </div>
            TXT1;
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="crcategoria.php" class="btn btn-info mb-2"><i class="fas fa-plus-circle"></i> Crear Categoria</a>
        <table class="table table-info table-striped">
            <thead>
                <tr>
                    <th scope="col">Detalles</th>
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
                        <th scope="row"><a href="dcategoria.php?id={$fila->id}" class="btn btn-light rounded-pill"><i class="fas fa-info-circle"></i> Detalles</a></th>
                        <td>{$fila->nombre}</td>
                        <td>{$fila->descripcion}</td>
                        <td>
                        <form name="delete" action="bcategoria.php" method="POST">
                            <input type="hidden" name="id" value="{$fila->id}"/>
                            <a href="ucategoria.php?id={$fila->id}" class="btn btn-warning rounded-circle"><i class="fas fa-pencil-alt"></i></a>
                            <button type="submit" class="btn btn-danger rounded-circle" onclick="return confirm('¿Deseas borrar la categoria?')"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        </td>
                    </tr>
                    TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>