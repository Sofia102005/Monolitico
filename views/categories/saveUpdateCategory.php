<?php
require_once '../../model/conexionDB/conexion.php';
require_once '../../model/entities/entity.php';
require_once '../../model/entities/Categories.php';
require_once '../../controller/CategoriesController.php';
require_once '../../controller/categoriesController.php';


use app\controller\CategoriesController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['nameInput'] ?? '');
    $percentage = floatval($_POST['percentageInput'] ?? 0);
    $id = $_POST['idInput'] ?? null;

    
    $errores = [];

    if (empty($name)) {
        $errores[] = "El nombre no puede estar vacío.";
    }

    if ($percentage <= 0 || $percentage > 100) {
        $errores[] = "El porcentaje debe ser mayor que 0 y menor o igual a 100.";
    }

    if (!empty($errores)) {
        echo "<script>alert('" . implode("\\n", $errores) . "'); history.back();</script>";
        exit;
    }

    $controller = new CategoriesController();

    if ($id) {
        // Actualizar categoría, pasar un array asociativo para que el controller lo entienda
        $request = [
            'idInput' => $id,
            'nameInput' => $name,
            'percentageInput' => $percentage
        ];
        $controller->updateCategory($request);
    } else {
        // Crear nueva categoría, pasar un array asociativo
        $request = [
            'nameInput' => $name,
            'percentageInput' => $percentage
        ];
        $controller->saveNewCategory($request);
    }

    // Redireccionar a la vista principal de categorías
    header("Location: categories.php");
    exit;

} else {
    header("Location: categories.php");
    exit;
}
