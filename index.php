<?php
require_once __DIR__ . '/model/model.php';
$mensaje = '';

$modelo = new Modelo(); // ← Instancia del modelo para poder llamar sus métodos

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensaje = 'Ingreso registrado correctamente.';
            break;
        case 'updated':
            $mensaje = 'Ingreso actualizado correctamente.';
            break;
        case 'error':
            $mensaje = 'Error al registrar el ingreso.';
            break;
    }
}

$incomes = $modelo->getAllIncomes(); // ← Llamamos correctamente al método
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Gastos - Ingresos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Registrar o Modificar Ingresos</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje-exito"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form action="controller/controller.php" method="POST">
        <label for="month">Mes:</label>
        <select name="month" id="month" required>
            <option value="">Seleccione un mes</option>
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
            <option value="Agosto">Agosto</option>
            <option value="Septiembre">Septiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
        </select>
        <br><br>

        <label for="year">Año:</label>
        <input type="number" name="year" id="year" required min="2000" max="2100">
        <br><br>

        <label for="amount">Ingreso (Valor):</label>
        <input type="number" name="amount" id="amount" required min="0" step="0.01">
        <br><br>

        <button type="submit">Guardar</button>
    </form>

    <h2>Historial de Ingresos</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Ingreso</th>
        </tr>
        <?php foreach ($incomes as $income): ?>
            <tr>
                <td><?php echo htmlspecialchars($income['month']); ?></td>
                <td><?php echo htmlspecialchars($income['year']); ?></td>
                <td>$<?php echo number_format($income['value'], 2, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
