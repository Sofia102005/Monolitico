<?php
include '../../model/entities/entity.php';
include '../../model/entities/income.php';
include '../../model/entities/reports.php';
include '../../controller/incomeController.php';
include '../../controller/reportsController.php';

use app\controller\incomeController;
use app\controller\reportsController;

$controller = new incomeController();

$result = empty($_POST['id'])
    ? $controller->saveNewIncome($_POST)
    : $controller->updateIncome($_POST);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <h1>Resultado de la operación</h1>
    <?php
    if ($result) {
        echo '<p>Datos guardados correctamente</p>';
    } else {
        echo '<p>No se pudo guardar los datos</p>';
    }
    ?>
    <a href="incomes">Volver </a>
</body>
</html>