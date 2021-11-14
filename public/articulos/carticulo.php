<?php
session_start();

require dirname(__DIR__, 2)."/vendor/autoload.php";

use source\{Articulos, Categorias};

$categorias = (new Categorias)->devolverCategorias();

$error = false; //Imaginemos que no hay ningun error en el documento
function hayError($nombre, $valor, $length)
{
    global $error;
    if ($nombre == "nombre") {
        if (strlen($valor) < $length) {
            $error = true;
            $_SESSION['err_nombre'] = "El precio debe tener al menos $length caracteres";
        }
        
    }
    if ($nombre == "precio") {
        if (strlen($valor) > $length) {
            $error = true;
            $_SESSION['err_precio'] = "El precio no debe pasar de $length caracteres";
        }
        
    }
    return $error;
}

if (isset($_POST['btnCrear'])) {
    # Procesamos el formulario
    $nombre = trim(ucfirst($_POST['nombre']));
    $precio = trim(ucfirst($_POST['precio']));
    $categoria = trim($_POST['categoria_id']);
    hayError("nombre", $nombre, 5);
    hayError("precio", $precio, 8);
    if (!$error) {
        # Si no hay error lo guardamos
        (new Articulos)->setNombre($nombre)
        ->setPrecio($precio)
        ->setCategoria_id($categoria)
        ->create();
        //Mandamos un mensaje de sesion diciendo que se ha creado
        $_SESSION['mensaje'] = "Articulo Creado";
        header("Location: index.php"); //Y nos vamos al index
        die();
    } else {
        # Ha habido un error lo mostramos en el form
        header("Location: {$_SERVER['PHP_SELF']}");
    }
} else {
    //Mostramos el formulario
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
    <title>Crear Articulo</title>
</head>

<body style="background-color:silver">
    <h3 class="text-center">Crear Articulo</h3>
    <div class="container mt-2">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="m-auto bg-primary text-white rounded p-4 shadow-lg" style="width: 48rem;">
                <div class="mb-3">
                    <label for="nombreArt" class="form-label">Nombre del Articulo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce el nombre aqui" required>
                    <?php
                        if (isset($_SESSION['err_nombre'])) {
                            echo <<< TXT
                            <div class="alert alert-danger text-black" role="alert">
                                {$_SESSION['err_nombre']}
                            </div>
                            TXT;
                            unset($_SESSION['err_nombre']);
                        }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio" placeholder="Introduce el precio aqui" required>
                    <?php
                        if (isset($_SESSION['err_precio'])) {
                            echo <<< TXT
                            <div class="alert alert-danger text-black" role="alert">
                                {$_SESSION['err_precio']}
                            </div>
                            TXT;
                            unset($_SESSION['err_precio']);
                        }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select class="form-select" aria-label="Default select example" name="categoria_id">
                        <?php
                        foreach ($categorias as $item) {
                            echo "<option value='{$item->id}'>{$item->nombre}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-outline-light" name="btnCrear"><i class="fas fa-cloud-upload-alt"></i> Guardar</button>
                    <button type="reset" class="btn btn-outline-warning"><i class="fas fa-broom"></i> Limpiar</button>
                </div>
        </form>
    </div>
</body>

</html>
<?php
}
?>