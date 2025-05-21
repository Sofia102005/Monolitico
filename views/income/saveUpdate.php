<?php
include '../../model/entities/entity.php';
include '../../model/entities/income.php';
include '../../model/entities/reports.php';
include '../../controller/incomeController.php';
include '../../controller/reportsController.php';

use app\controller\incomeController;
use app\controller\reportsController;

$request = $_POST;
$controllerIncome = new incomeController();
$controllerReport = new reportsController();

if (empty($request['idInput'])) {
    // Crear nuevo ingreso

    // 1. Validar que vienen los datos del reporte
    if (!empty($request['monthInput']) && !empty($request['yearInput'])) {
        // 2. Guardar el reporte y obtener el ID insertado
        $idReport = $controllerReport->saveNewReports($request);

        if ($idReport !== false) {
            $request['idReportInput'] = intval($idReport);
            $result = $controllerIncome->saveNewIncome($request);
        } else {
            $result = false;
        }
    } else {
        $result = false;
    }
} else {
    // Actualizar ingreso existente (se supone que ya viene con idReportInput en el formulario si lo editas)
    $result = $controllerIncome->updateIncome($request);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
       <link rel="stylesheet" href="../../estilos.css">
</head>
<body>
    <h1>Resultado de la operación</h1>
    <?php if ($result): ?>
        <p>Datos guardados correctamente.</p>
    <?php else: ?>
        <p>No se pudo guardar los datos.</p>
    <?php endif; ?>
    <a href="incomes.php">Volver</a>
</body>
</html>