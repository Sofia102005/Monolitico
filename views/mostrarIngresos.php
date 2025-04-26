<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresos Mensuales</title>
    <link rel="stylesheet" href="views/estilos.css">
</head>
<body>
    <h1>Lista de Ingresos</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Valor</th>
            <th>Reporte</th>
        </tr>
        <?php foreach($ingresos as $ingreso): ?>
        <tr>
            <td><?php echo $ingreso['id']; ?></td>
            <td><?php echo $ingreso['value']; ?></td>
            <td><?php echo $ingreso['idReport']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
