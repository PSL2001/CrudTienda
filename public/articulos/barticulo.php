<?php

use source\Articulos;

if (!isset($_POST['id'])) {
    header("Location: index.php");
    die();
}
session_start();

require dirname(__DIR__, 2)."/vendor/autoload.php";

(new Articulos)->setId($_POST['id'])->delete();

$_SESSION['mensaje'] = "Articulo eliminado";

header("Location: index.php");

