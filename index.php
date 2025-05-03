<?php
require_once __DIR__ . '/model/modelIngreso.php';
$mensaje = '';

$modelo = new ModeloIngreso();

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensaje = 'Ingreso registrado correctamente.';
            break;
        case 'updated':
            $mensaje = 'Ingreso actualizado correctamente.';
            break;
        case 'deleted':
            $mensaje = 'Ingreso eliminado correctamente.';
            break;
        case 'error':
            $mensaje = 'Error al procesar la solicitud.';
            break;
    }
}

$incomes = $modelo->getAllIncomes();
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

    <h1>Registrar, Modificar o Eliminar Ingresos</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje-exito"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form action="controller/controller.php" method="POST">
        <input type="hidden" name="action" value="addIncome"> 

        <label for="month">Mes:</label>
        <select name="month" id="month" required>
            <option value="">Seleccione un mes</option>
            <?php 
            $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            foreach ($meses as $mes): ?>
                <option value="<?php echo htmlspecialchars($mes); ?>" <?php if (in_array($mes, array_column($incomes, 'month'))): ?> disabled <?php endif; ?>><?php echo htmlspecialchars($mes); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="year">Año:</label>
        <input type="number" name="year" id="year" required min="2000" max="2100">

        <label for="amount">Ingreso (Valor):</label>
        <input type="number" name="amount" id="amount" required min="0" step="0.01">

        <button type="submit">Guardar ingreso</button>
    </form>

    <h2>Historial de Ingresos</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($incomes as $income): ?>
            <tr>
                <td><?php echo htmlspecialchars($income['month']); ?></td>
                <td><?php echo htmlspecialchars($income['year']); ?></td>
                <td>$<?php echo number_format($income['value'], 2, ',', '.'); ?></td>
                <td>
                    <!-- Formulario para actualizar este ingreso -->
                    <form action="controller/controller.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="updateIncome">
                        <input type="hidden" name="idIncome" value="<?php echo $income['idIncome']; ?>">
                        <input type="number" name="amount" placeholder="Nuevo valor" required step="0.01">
                        <button type="submit">Actualizar</button>
                    </form>

                    <!-- Formulario para eliminar este ingreso -->
                    <form action="controller/controller.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="deleteIncome">
                        <input type="hidden" name="idIncome" value="<?php echo $income['idIncome']; ?>">
                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este ingreso?');">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>