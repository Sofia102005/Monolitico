<?php
$month = $_GET['month'] ?? '';
$year = $_GET['year'] ?? '';

session_start();

if (isset($_GET['month']) && isset($_GET['year'])) {
    $_SESSION['month'] = $month;
    $_SESSION['year'] = $year;
    echo "Mes: " . htmlspecialchars($_GET['month']) . ", Año: " . htmlspecialchars($_GET['year']);
} else {
    echo "No se han pasado los valores de mes y año";
}

require_once dirname(__DIR__) . '/model/modelIngreso.php';
require_once dirname(__DIR__) . '/model/modelgastos.php';
require_once '../controller/controllerGastos.php';

$modeloGasto = new ModeloGasto();

$categorias = $modeloGasto->getCategorias();
$month = $_SESSION['month'] ?? '';
$year = $_SESSION['year'] ?? '';

$bills = $modeloGasto->getBillsByMonth($month, $year);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>
    <h1>Registrar, Modificar o Eliminar Gastos</h1>

    <form action="../controller/controllerGastos.php" method="POST">
        <input type="hidden" name="action" value="addBill">

        <label for="amount_bill">Gasto (Valor):</label>
        <input type="number" name="amount" id="amount_bill" required min="0" step="0.01">

        <label for="category">Categoría:</label> <!--Toca corregir esto, solo se debe agregar un porcentaje para que este porcentaje sea el que se muestre y reste de los ingresos-->
        <select name="categoryId" id="category" required>
            <option value="">Porcentaje</option> 
            <?php foreach ($categorias as $categoria): ?> 
                <option value="<?= $categoria['id']; ?>"><?= htmlspecialchars($categoria['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar gasto</button>
    </form>

    <h2>Historial de Gastos para el mes de <?php echo htmlspecialchars($_SESSION['month'] ?? ''); ?> del año <?php echo htmlspecialchars($_SESSION['year'] ?? ''); ?></h2>
    
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Gasto</th>
                <th>Porcentaje</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bills as $bill): ?>
                <tr>
                    <td><?php echo htmlspecialchars($bill['month']); ?></td>
                    <td><?php echo htmlspecialchars($bill['year']); ?></td>
                    <td>$<?php echo number_format($bill['value'], 2, ',', '.'); ?></td>
                    <td>
                        <form action="../controller/controllerGastos.php" method="POST">
                            <input type="hidden" name="action" value="updateBill">
                            <input type="hidden" name="idBill" value="<?php echo $bill['idBill']; ?>">
                            <input type="number" name="amount" placeholder="Nuevo valor" required step="0.01">
                            <select name="categoryId" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id']; ?>"><?= htmlspecialchars($categoria['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">Actualizar</button>
                        </form>

                        <form action="../controller/controllerGastos.php" method="POST">
                            <input type="hidden" name="action" value="deleteBill">
                            <input type="hidden" name="idBill" value="<?php echo $bill['idBill']; ?>">
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este gasto?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</body>

</html>