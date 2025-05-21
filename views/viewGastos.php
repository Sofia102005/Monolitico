<?php
session_start();

$month = $_GET['month'] ?? '';
$year = $_GET['year'] ?? '';

if (!empty($month) && !empty($year)) {
    $_SESSION['month'] = $month;
    $_SESSION['year'] = $year;
}

$month = $_SESSION['month'] ?? '';
$year = $_SESSION['year'] ?? '';

require_once __DIR__ . '/../controller/CategoriesController.php';
require_once __DIR__ . '/../model/entities/ModeloGasto.php';

use app\controller\CategoriesController;
use app\model\entities\ModeloGasto;

$categoriesController = new CategoriesController();
$categorias = $categoriesController->queryAllCategories();

$modeloGasto = new ModeloGasto();

$bills = [];
if ($month !== '' && $year !== '') {
    $bills = $modeloGasto->getBillsByMonth($month, $year);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<h1>Registrar, Modificar o Eliminar Gastos</h1>

<div class="tabla-container">
    <form action="../controller/controllerGastos.php" method="POST" class="formulario-gasto">
        <input type="hidden" name="action" value="addBill">

        <label for="name">Nombre del Gasto:</label>
        <input type="text" name="name" required>

        <label for="amount">Valor (€):</label>
        <input type="number" name="amount" min="0" step="0.01" required>

        <label for="categoryId">Categoría:</label>
        <select name="categoryId" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria->get('id'); ?>"><?= htmlspecialchars($categoria->get('name')); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="month">Mes:</label>
        <input type="number" name="month" min="1" max="12" value="<?= htmlspecialchars($month) ?>" required>

        <label for="year">Año:</label>
        <input type="number" name="year" min="2000" max="2100" value="<?= htmlspecialchars($year) ?>" required>

        <button type="submit">Guardar Gasto</button>
    </form>
</div>

<?php if ($month !== '' && $year !== ''): ?>
    <h2 class="subtitulo">Historial de Gastos: <?= htmlspecialchars($month) ?>/<?= htmlspecialchars($year) ?></h2>

    <?php if (count($bills) === 0): ?>
        <p class="mensaje-alerta">No hay gastos registrados para este período.</p>
    <?php else: ?>
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Categoría</th>
                    <th>Valor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?= htmlspecialchars($bill['month']); ?></td>
                        <td><?= htmlspecialchars($bill['year']); ?></td>
                        <td><?= htmlspecialchars($bill['category']); ?></td>
                        <td>€<?= number_format($bill['value'], 2, ',', '.'); ?></td>
                        <td>
                            <form action="../controller/controllerGastos.php" method="POST" class="form-accion">
                                <input type="hidden" name="action" value="updateBill">
                                <input type="hidden" name="idBill" value="<?= $bill['idBill']; ?>">

                                <input type="number" name="amount" placeholder="Nuevo valor" required step="0.01" class="input-pequeno">

                                <select name="categoryId" required>
                                    <option value="">Categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria->get('id'); ?>"><?= htmlspecialchars($categoria->get('name')); ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <button type="submit" class="boton-tabla">Actualizar</button>
                            </form>

                            <form action="../controller/controllerGastos.php" method="POST" class="form-accion">
                                <input type="hidden" name="action" value="deleteBill">
                                <input type="hidden" name="idBill" value="<?= $bill['idBill']; ?>">
                                <button type="submit" class="boton-tabla" onclick="return confirm('¿Eliminar este gasto?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php else: ?>
    <p class="mensaje-alerta">Debe ingresar mes y año para ver los gastos.</p>
<?php endif; ?>

<div class="botones-container">
    <a href="../index.php" class="boton">Volver al Inicio</a>
</div>

</body>
</html>