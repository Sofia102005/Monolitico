<?php
include '../../model/conexionDB/conexion.php';
include '../../model/entities/entity.php';
include '../../model/entities/income.php';
include '../../model/entities/reports.php';
include '../../controller/incomeController.php';
include '../../controller/reportsController.php';

use app\controller\incomeController;
use app\controller\reportsController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = $_POST;

    $controller1 = new reportsController();
    $idReport = $controller1->saveNewReports($request); // Se guarda el reporte y obtienes el ID

    $request['idReportInput'] = $idReport; // Lo agrega al array que irá a saveNewIncome

    $controller = new incomeController();
    $controller->saveNewIncome($request); // Con idReport válido
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>

<body>
    <h1>
        <?php echo empty($_GET['id']) ? 'Registrar incomes' : 'Modificar'; ?>
    </h1>
    <form action="saveUpdate.php" method="post">
        <?php
        if (!empty($_GET['id'])) {
            echo '<input type="hidden" name="idInput" value="' . $_GET['id'] . '">';
        }
        ?>
        <div>
            <label>value</label>
            <input type="number" name="valueInput" required>
        </div>
        <input type="hidden" name="idReportInput" >
        <div>
            <label>month</label>
            <input type="text" name="monthInput" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+" title="Solo letras permitidas" required>
        </div>
        <div>
            <label>year</label>
            <input type="number" name="yearInput" min="1900" max="2025" required>
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
    </form>
    <a href="persons.php">Volver</a>
</body>
</html>