<?php

use source\Categorias;

if (!isset($_POST['id'])) { //Comprobamos que nos pasan la id
    header("Location: index.php");
    die();
}
$id = $_POST['id'];

session_start();

require dirname(__DIR__, 2)."/vendor/autoload.php";
(new Categorias)->setId($id)->delete();

$_SESSION['mensaje'] = "Categoria eliminada";

header("Location: index.php");