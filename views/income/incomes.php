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
    <title>Income</title>
</head>

<body>
    <h1>Income</h1>
    <br>

    <table>
        <thead>
            <tr>
                <th>value</th>
                <th>month</th>
                <th>year</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($incomes as $income) {
                echo '<tr>';
                echo '  <td>' . $income->get('value') . '</td>';
                echo '  <td>' . $income->get('month') . '</td>';
                echo '  <td>' . $income->get('year') . '</td>';
                echo '  <td>';
                echo '      <a href="form_person.php?id=' . $income->get('id') . '">Modificar</a>';
                echo '       ';
                echo '  </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <a href="form.php">Crear</a>
</body>

</html>