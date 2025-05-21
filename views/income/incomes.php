<?php
include '../../model/conexionDB/conexion.php';
include '../../model/entities/entity.php';
include '../../model/entities/income.php';
include '../../controller/incomeController.php';

use app\controller\incomeController;

$controller = new incomeController();
$incomes = $controller->queryAllIncome();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos Reporte</title>
    <link rel="stylesheet" href="../../estilos.css">
</head>

<body>
    <h1>Ingresos Registrados</h1>

    <div class="tabla-container">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($incomes as $income) {
                    echo '<tr>';
                    echo '  <td>' . $income->get('value') . '</td>';
                    echo '  <td>' . $income->get('month') . '</td>';
                    echo '  <td>' . $income->get('year') . '</td>';
                    echo '  <td><a class="boton boton-tabla" href="form.php?id=' . $income->get('id') . '">Modificar</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>
    <div class="botones-container">
        <a class="boton" href="form.php">Crear nuevo ingreso</a>
        <a class="boton" href="../../index.php">Volver al inicio</a>
    </div>
</body>

</html>

