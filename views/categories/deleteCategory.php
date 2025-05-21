<?php
include '../../model/conexionDB/conexion.php';
include '../../model/entities/entity.php';
include '../../model/entities/categories.php';
include '../../controller/categoriesController.php';

use app\controller\categoriesController;

$controller = new categoriesController();
$result = $controller->deleteCategory($_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la operación</title>
</head>
<body>
    <h1>Resultado de la operación</h1>
    <p><?php echo $result; ?></p>
    <a href="categories.php">Volver</a>
</body>
</html>
