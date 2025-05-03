<?php
require_once __DIR__ . '/../model/modelingreso.php';
$modelo = new ModeloIngreso();

// Registrar Ingreso
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $descripcion = $_POST['descripcion'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $mes = $_POST['mes'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $idIngreso = $_POST['id'] ?? null;

    if ($accion === 'agregar' && $valor > 0 && !empty($descripcion) && !empty($mes) && !empty($anio)) {
        $modelo->addIncome($mes, $anio, $valor); 
    } elseif ($accion === 'modificar' && $idIngreso && $valor > 0) {
        $modelo->updateIncome($idIngreso, $valor); 
    } elseif ($accion === 'eliminar' && $idIngreso) {
        $modelo->deleteIncome($idIngreso);
    }
}

$ingresos = [];
if (isset($_GET['mes'], $_GET['anio'])) {
    $ingresos = $modelo->getAllIncomes(); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresos Mensuales</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Ingresos Mensuales</h1>

    <form method="GET">
        <label>Mes:</label>
        <input type="text" name="mes" required>
        <label>Año:</label>
        <input type="number" name="anio" required>
        <button type="submit">Ver Ingresos</button>
    </form>

    <h2>Agregar / Modificar Ingreso</h2>
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

    <h2>Lista de Ingresos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Valor</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($ingresos as $ingreso): ?>
        <tr>
            <td><?= $ingreso['idIncome'] ?></td>
            <td><?= $ingreso['month'] ?></td>
            <td><?= $ingreso['year'] ?></td>
            <td><?= $ingreso['value'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $ingreso['idIncome'] ?>">
                    <input type="hidden" name="valor" value="<?= $ingreso['value'] ?>">
                    <input type="hidden" name="accion" value="modificar">
                    <button type="submit">Editar</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $ingreso['idIncome'] ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>