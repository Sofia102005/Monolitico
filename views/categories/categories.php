<?php
require_once '../../model/conexionDB/conexion.php';
require_once '../../model/entities/entity.php';
require_once '../../model/entities/Categories.php';
require_once '../../controller/CategoriesController.php';

use app\controller\CategoriesController;

$controller = new CategoriesController();
$categories = $controller->queryAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <link rel="stylesheet" href="../../estilos.css">
</head>
<body>

<h1 style="text-align:center;">Categorías de Gasto</h1>
<br>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Porcentaje</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category->get('name')) ?></td>
                    <td><?= htmlspecialchars($category->get('percentage')) ?>%</td>
                    <td>
                        <a class="boton" href="form.php?id=<?= $category->get('id') ?>">Modificar</a>
                        <a class="boton" href="deleteCategory.php?id=<?= $category->get('id') ?>" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hay categorías registradas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <a href="form.php" class="boton">Crear Categoría</a>
    <a href="../../index.php" class="boton">Volver al Inicio</a>
</div>

</body>
</html>
