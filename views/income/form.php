<?php
require_once '../../model/conexionDB/conexion.php';
require_once '../../model/entities/entity.php';
require_once '../../model/entities/income.php';
require_once '../../model/entities/reports.php';
require_once '../../model/entities/Categories.php';
require_once '../../controller/incomeController.php';
require_once '../../controller/reportsController.php';
require_once '../../controller/CategoriesController.php';

use app\controller\incomeController;
use app\controller\reportsController;
use app\controller\CategoriesController;

$isEditMode = !empty($_GET['id']);
$isCategory = isset($_GET['type']) && $_GET['type'] === 'category';

$incomeData = null;
$categoryData = null;


if (!$isCategory && $isEditMode) {
    $controller = new incomeController();
    $allIncomes = $controller->queryAllIncome();

    foreach ($allIncomes as $inc) {
        if ($inc->get('id') == $_GET['id']) {
            $incomeData = $inc;
            break;
        }
    }
}


if ($isCategory && $isEditMode) {
    $catController = new CategoriesController();
    $categories = $catController->queryAllCategories();

    foreach ($categories as $cat) {
        if ($cat->get('id') == $_GET['id']) {
            $categoryData = $cat;
            break;
        }
    }
}

// Mes y año actuales si es nuevo ingreso
if (!$isEditMode && !$isCategory) {
    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];
    $currentMonth = date('F');
    $monthInSpanish = $meses[$currentMonth];
    $currentYear = date('Y');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $isCategory ? ($isEditMode ? 'Modificar Categoría' : 'Crear Categoría') : ($isEditMode ? 'Modificar Ingreso' : 'Registrar Ingreso') ?></title>
    <link rel="stylesheet" href="../../estilos.css">
    </head>
<body>

<h1><?= $isCategory ? ($isEditMode ? 'Modificar Categoría' : 'Crear Categoría') : ($isEditMode ? 'Modificar Ingreso' : 'Registrar Ingreso') ?></h1>

<form action="<?= $isCategory ? 'saveUpdateCategory.php' : 'saveUpdate.php' ?>" method="post">
    <?php if ($isEditMode): ?>
        <input type="hidden" name="idInput" value="<?= $isCategory ? htmlspecialchars($categoryData->get('id')) : htmlspecialchars($incomeData->get('id')) ?>">
        <?php if (!$isCategory): ?>
            <input type="hidden" name="idReportInput" value="<?= htmlspecialchars($incomeData->get('idReport')) ?>">
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($isCategory): ?>
        
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

    <?php else: ?>
       
        <div>
            <label for="valueInput">Valor</label>
            <input type="number" id="valueInput" name="valueInput" required min="0"
                   value="<?= $isEditMode ? htmlspecialchars($incomeData->get('value')) : '' ?>">
        </div>

        <?php if (!$isEditMode): ?>
            <div>
                <label for="monthInput">Mes</label>
                <input type="text" id="monthInput" name="monthInput" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" required
                       value="<?= htmlspecialchars($monthInSpanish) ?>">
            </div>
            <div>
                <label for="yearInput">Año</label>
                <input type="number" id="yearInput" name="yearInput" min="1900" max="2100" required
                       value="<?= htmlspecialchars($currentYear) ?>">
            </div>
        <?php else: ?>
            <div>
                <label>Mes</label>
                <input type="text" value="<?= htmlspecialchars($incomeData->get('month')) ?>" readonly>
            </div>
            <div>
                <label>Año</label>
                <input type="number" value="<?= htmlspecialchars($incomeData->get('year')) ?>" readonly>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div>
        <button type="submit" class="boton">
            <i class="fa-solid fa-floppy-disk"></i>
            <?= $isEditMode ? 'Actualizar' : 'Guardar' ?>
        </button>
    </div>
</form>

<div class="botones-container">
    <a class="boton" href="<?= $isCategory ? 'categories.php' : 'incomes.php' ?>">
        <i class="fa-solid fa-arrow-left"></i> Volver
    </a>
</div>

</body>
</html>
