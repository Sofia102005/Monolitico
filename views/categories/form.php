<?php
require_once '../../model/conexionDB/conexion.php';
require_once '../../model/entities/entity.php';
require_once '../../model/entities/Categories.php';
require_once '../../controller/CategoriesController.php';

use app\controller\CategoriesController;

$isEditMode = !empty($_GET['id']);
$categoryData = null;

if ($isEditMode) {
    $controller = new CategoriesController();
    $categories = $controller->queryAllCategories();

    foreach ($categories as $cat) {
        if ($cat->get('id') == $_GET['id']) {
            $categoryData = $cat;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $isEditMode ? 'Modificar Categoría' : 'Crear Categoría' ?></title>
    <link rel="stylesheet" href="../../estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<h1><?= $isEditMode ? 'Modificar Categoría' : 'Crear Categoría' ?></h1>

<form action="saveUpdateCategory.php" method="post">
    <?php if ($isEditMode): ?>
        <input type="hidden" name="idInput" value="<?= htmlspecialchars($categoryData->get('id')) ?>">
    <?php endif; ?>

    <div>
        <label for="nameInput">Nombre de Categoría</label>
        <input type="text" id="nameInput" name="nameInput" required
               value="<?= $isEditMode ? htmlspecialchars($categoryData->get('name')) : '' ?>">
    </div>

    <div>
        <label for="percentageInput">Porcentaje (%)</label>
        <input type="number" id="percentageInput" name="percentageInput" required min="1" max="100"
               value="<?= $isEditMode ? htmlspecialchars($categoryData->get('percentage')) : '' ?>">
    </div>

    <div>
        <button type="submit" class="boton">
            <i class="fa-solid fa-floppy-disk"></i>
            <?= $isEditMode ? 'Actualizar' : 'Guardar' ?>
        </button>
    </div>
</form>

<div class="botones-container">
    <a class="boton" href="categories.php"><i class="fa-solid fa-arrow-left"></i> Volver</a>
</div>

</body>
</html>
