<?php
require_once __DIR__ . '/../model/model.php';
$modelo = new Modelo();

// Registrar gasto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $descripcion = $_POST['descripcion'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $mes = $_POST['mes'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $idGasto = $_POST['id'] ?? null;

    if ($accion === 'agregar' && $valor > 0 && !empty($descripcion) && !empty($mes) && !empty($anio)) {
        $modelo->addExpense($descripcion, $valor, $mes, $anio);
    } elseif ($accion === 'modificar' && $idGasto && $valor > 0) {
        $modelo->updateExpense($idGasto, $descripcion, $valor);
    } elseif ($accion === 'eliminar' && $idGasto) {
        $modelo->deleteExpense($idGasto);
    }
}

$gastos = [];
if (isset($_GET['mes'], $_GET['anio'])) {
    $gastos = $modelo->getExpenses($_GET['mes'], $_GET['anio']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gastos Mensuales</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Gastos Mensuales</h1>

    <form method="GET">
        <label>Mes:</label>
        <input type="text" name="mes" required>
        <label>Año:</label>
        <input type="number" name="anio" required>
        <button type="submit">Ver Gastos</button>
    </form>

    <h2>Agregar / Modificar Gasto</h2>
    <form method="POST">
        <input type="hidden" name="id" id="id">
        <label>Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" required>
        <label>Valor:</label>
        <input type="number" name="valor" id="valor" min="0" step="0.01" required>
        <input type="hidden" name="mes" value="<?= $_GET['mes'] ?? '' ?>">
        <input type="hidden" name="anio" value="<?= $_GET['anio'] ?? '' ?>">
        <button type="submit" name="accion" value="agregar">Agregar</button>
        <button type="submit" name="accion" value="modificar">Modificar</button>
    </form>

    <h2>Lista de Gastos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Valor</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($gastos as $gasto): ?>
        <tr>
            <td><?= $gasto['id'] ?></td>
            <td><?= $gasto['description'] ?></td>
            <td><?= $gasto['value'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $gasto['id'] ?>">
                    <input type="hidden" name="descripcion" value="<?= $gasto['description'] ?>">
                    <input type="hidden" name="valor" value="<?= $gasto['value'] ?>">
                    <input type="hidden" name="accion" value="modificar">
                    <button type="submit">Editar</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $gasto['id'] ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
