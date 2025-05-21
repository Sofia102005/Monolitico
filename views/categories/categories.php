<?php
include '../../model/conexionDB/conexion.php';
include '../../model/entities/entity.php';
include '../../model/entities/categories.php';
include '../../controller/categoriesController.php';

use app\controller\categoriesController;

$controller = new categoriesController();
$categories = $controller->queryAllCategories();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>categories</title>
</head>

<body>
    <h1>Categories</h1>
    <br>

    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>percentage</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($categories as $category) {
                echo '<tr>';
                echo '  <td>' . $category->get('name') . '</td>';
                echo '  <td>' . $category->get('percentage') . '</td>';
                echo '  <td>';
                echo '      <a href="form.php ? id=' . $category->get('id') . '">Modificar</a>';
                echo '       ';
                echo '  </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <a href="form.php">Crear</a>
    <a href="../../index.php">volver al index</a>
</body>
</html>