<?php
require_once __DIR__ . '/../model/model.php'; // Incluye el modelo

$modelo = new Modelo(); // Instanciamos correctamente tu clase 'Modelo'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $amount = $_POST['amount'] ?? '';

    if (!empty($month) && !empty($year) && is_numeric($amount) && $amount > 0) {
        $resultado = $modelo->addOrUpdateIncome($month, $year, $amount); // Usamos el método de la clase
        if ($resultado === 'actualizado') {
            header('Location: ../index.php?status=updated');
        } else {
            header('Location: ../index.php?status=success');
        }
        exit;
    } else {
        header('Location: ../index.php?status=error');
        exit;
    }
}
?>
