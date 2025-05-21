<?php
include '../../model/conexionDB/conexion.php';
include '../../model/entities/entity.php';
include '../../model/entities/income.php';
include '../../model/entities/reports.php';
include '../../controller/incomeController.php';
include '../../controller/reportsController.php';

use app\controller\incomeController;
use app\controller\reportsController;

$isEditMode = !empty($_GET['id']);
$incomeData = null;

if ($isEditMode) {
    $controller = new incomeController();
    $allIncomes = $controller->queryAllIncome();

    foreach ($allIncomes as $inc) {
        if ($inc->get('id') == $_GET['id']) {
            $incomeData = $inc;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isEditMode ? 'Modificar Ingreso' : 'Crear Ingreso'; ?></title>
    <link rel="stylesheet" href="../../estilos.css">
    <!-- Íconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<h1><?php echo $isEditMode ? 'Modificar Ingreso' : 'Registrar Ingreso'; ?></h1>

<form action="saveUpdate.php" method="post">
    <?php if ($isEditMode): ?>
        <input type="hidden" name="idInput" value="<?php echo htmlspecialchars($incomeData->get('id')); ?>">
        <input type="hidden" name="idReportInput" value="<?php echo htmlspecialchars($incomeData->get('idReport')); ?>">
    <?php endif; ?>

    <div>
        <label>Valor</label>
        <input type="number" name="valueInput" required min="0"
            value="<?php echo $isEditMode ? htmlspecialchars($incomeData->get('value')) : ''; ?>">
    </div>

    <?php if (!$isEditMode): ?>
        <div>
            <label>Mes</label>
            <input type="text" name="monthInput" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" required>
        </div>
        <div>
            <label>Año</label>
            <input type="number" name="yearInput" min="1900" max="2025" required>
        </div>
    <?php else: ?>
        <div>
            <label>Mes</label>
            <input type="text" value="<?php echo htmlspecialchars($incomeData->get('month')); ?>" readonly>
        </div>
        <div>
            <label>Año</label>
            <input type="number" value="<?php echo htmlspecialchars($incomeData->get('year')); ?>" readonly>
        </div>
    <?php endif; ?>

    <div>
        <button type="submit" class="boton">
            <i class="fa-solid fa-floppy-disk"></i>
            <?php echo $isEditMode ? 'Actualizar' : 'Guardar'; ?>
        </button>
    </div>
</form>

<div class="botones-container">
    <a class="boton" href="incomes.php"><i class="fa-solid fa-arrow-left"></i> Volver</a>
</div>

</body>
</html>
