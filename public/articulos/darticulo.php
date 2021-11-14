<?php

use source\{Articulos, Categorias};

if (!isset($_GET['id'])) {
    header("index.php");
    die();
}

require dirname(__DIR__, 2) . "/vendor/autoload.php";

$articulo = (new Articulos)->read($_GET['id']);

$categorias = (new Categorias)->devolverCategorias();
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
    <title>Detalles</title>
</head>

<body style="background-color:silver">
    <h3 class="text-center">Detalles Categoria</h3>
    <div class="container mt-2">
        <div class="card bg-warning mx-auto" style="width: 28rem;">
            <div class="card-header">
                Detalles Categoria <?php echo $articulo->id ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $articulo->nombre ?></h5>
                <p class="card-text"><?php echo $articulo->precio ?></p>
                <?php
                foreach ($categorias as $item) {
                    if ($item->id == $articulo->categoria_id) {
                        echo "<p class='card-text'>{$item->nombre}</p>";
                    }
                }
                ?>
                <a href="index.php" class="btn btn-outline-primary"><i class="fas fa-backward"></i> Volver</a>
            </div>
        </div>
    </div>
</body>

</html>