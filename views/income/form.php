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
    // Cargar ingreso por ID para mostrar datos en el formulario
    $controller = new incomeController();
    $allIncomes = $controller->queryAllIncome();

    // Buscar el ingreso con el id solicitado
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
</head>
<body>

<h1><?php echo $isEditMode ? 'Modificar Ingreso' : 'Registrar Ingreso'; ?></h1>

<form action="saveUpdate.php" method="post">
    <?php
    if ($isEditMode) {
        echo '<input type="hidden" name="idInput" value="' . htmlspecialchars($incomeData->get('id')) . '">';
        // También necesitas el idReport para actualizar, pero oculto (no editable)
        // Suponemos que income tiene idReport, pero no está cargado en el objeto, habría que agregarlo en Income::all()
        // Si no tienes idReport en Income::all(), tendrás que modificar ese método para incluirlo
        // Por ahora asumiremos que se agregó:
        echo '<input type="hidden" name="idReportInput" value="' . htmlspecialchars($incomeData->get('idReport')) . '">';
    }
    ?>
    <div>
        <label>Valor</label>
        <input type="number" name="valueInput" required min="0" value="<?php echo $isEditMode ? htmlspecialchars($incomeData->get('value')) : ''; ?>">
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
        <button type="submit"><?php echo $isEditMode ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>

<a href="incomes.php">Volver</a>

</body>
</html>
