<?php
require_once __DIR__ . '/../model/modelIngreso.php';

$modelo = new ModeloIngreso();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $redirect = '../index.php?status=';

    try {
        switch ($action) {
            case 'addIncome':
                $month = $_POST['month'];
                $year = $_POST['year'];
                $amount = floatval($_POST['amount']);
                $resultado = $modelo->addIncome($month, $year, $amount);
                header("Location: $redirect" . ($resultado === 'nuevo' ? 'success' : 'error'));
                break;

            case 'updateIncome':
                $idIncome = $_POST['idIncome'];
                $amount = floatval($_POST['amount']);
                $resultado = $modelo->updateIncome($idIncome, $amount);
                header("Location: $redirect" . ($resultado === 'actualizado' ? 'updated' : 'error'));
                break;

            case 'addAmount':
                $idIncome = $_POST['idIncome'];
                $amount = floatval($_POST['amount']);
                $resultado = $modelo->addAmount($idIncome, $amount);
                header("Location: $redirect" . ($resultado === 'actualizado' ? 'updated' : 'error'));
                break;

            case 'deleteIncome':
                $idIncome = $_POST['idIncome'];
                $resultado = $modelo->deleteIncome($idIncome);
                header("Location: $redirect" . ($resultado === 'eliminado' ? 'deleted' : 'error'));
                break;

            default:
                header("Location: $redirect" . 'error');
                break;
        }
    } catch (Exception $e) {
        header("Location: $redirect" . 'error');
    }
    exit;
}
