<?php
require_once '../model/modelgastos.php';

$modelo = new ModeloGasto();
$bills = $modelo->getAllBills();

$categorias = $modelo->getCategorias(); // Obtener las categorías

$mensaje = '';
if (isset($_GET['status'])) {
    $estados = [
        'success' => 'Gasto registrado correctamente.',
        'updated' => 'Gasto actualizado correctamente.',
        'deleted' => 'Gasto eliminado correctamente.',
        'error'   => 'Error al procesar la solicitud.'
    ];
    $mensaje = $estados[$_GET['status']] ?? '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Gastos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Registrar o Gestionar Gastos</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje-exito"><?php echo $mensaje ?></div>
    <?php endif; ?>

    <form action="controller/controllerGastos.php" method="POST">
        <input type="hidden" name="action" value="addBill">

        <label for="amount">Valor (€):</label>
        <input type="number" name="amount" step="0.01" required>

        <label for="categoryId">Categoría:</label>
        <select name="categoryId" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="month">Mes:</label>
        <input type="number" name="month" min="1" max="12" required>

        <label for="year">Año:</label>
        <input type="number" name="year" min="2000" max="2100" required>

        <button type="submit">Guardar Gasto</button>
    </form>

    <h2>Historial de Gastos</h2>

    <table border="1">
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
                    <td><?= htmlspecialchars($bill['month']) ?></td>
                    <td><?= htmlspecialchars($bill['year']) ?></td>
                    <td><?= htmlspecialchars($bill['category']) ?></td>
                    <td>€<?= number_format($bill['value'], 2, ',', '.') ?></td>
                    <td>
                        <!-- Formulario de actualización -->
                        <form action="controller/controllerGastos.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="updateBill">
                            <input type="hidden" name="idBill" value="<?php echo $bill['idBill'] ?>">
                            <input type="number" name="amount" placeholder="Nuevo valor" step="0.01" required>
                            <select name="categoryId" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">Actualizar</button>
                        </form>

                        <form action="controller/controllerGastos.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="deleteBill">
                            <input type="hidden" name="idBill" value="<?= $bill['idBill'] ?>">
                            <button type="submit" onclick="return confirm('¿Eliminar este gasto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>