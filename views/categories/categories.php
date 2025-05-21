<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <link rel="stylesheet" href="../../estilos.css"> 
</head>

<body>
    <h1>Categories</h1>
    <br>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Percentage</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category->get('name') ?></td>
                    <td><?= $category->get('percentage') ?></td>
                    <td>
                        <a class="boton" href="form.php?id=<?= $category->get('id') ?>">Modificar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="text-align: center;">
        <a href="form.php" class="boton">Crear</a>
        <a href="../../index.php" class="boton">Volver al index</a>
    </div>
</body>
</html>
