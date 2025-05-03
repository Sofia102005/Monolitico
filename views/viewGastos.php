<?php
require_once dirname(__DIR__) . '/model/modelIngreso.php';
require_once dirname(__DIR__) . '/model/modelgastos.php';
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

<form action="controller/controller.php" method="POST">
    <input type="hidden" name="action" value="addBill">

    <label for="month_bill">Mes:</label>
    <select name="month" id="month_bill" required>
        <option value="">Seleccione un mes</option>
        <?php foreach ($meses as $mes): ?>
            <option value="<?php echo htmlspecialchars($mes); ?>"><?php echo htmlspecialchars($mes); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="year_bill">Año:</label>
    <input type="number" name="year" id="year_bill" required min="2000" max="2100">

    <label for="amount_bill">Gasto (Valor):</label>
    <input type="number" name="amount" id="amount_bill" required min="0" step="0.01">

    <label for="category">Categoría:</label>
    <select name="categoryId" id="category" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id']; ?>"><?= htmlspecialchars($categoria['name']); ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Guardar gasto</button>
</form>

<h2>Historial de Gastos</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Gasto</th>
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
                    <form action="controller/controller.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="updateBill">
                        <input type="hidden" name="idBill" value="<?php echo $bill['idBill']; ?>">
                        <input type="number" name="amount" placeholder="Nuevo valor" required step="0.01">
                        <button type="submit">Actualizar</button>
                    </form>

                    <form action="controller/controller.php" method="POST" style="display:inline;">
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