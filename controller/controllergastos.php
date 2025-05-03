<?php
require_once __DIR__ . '/../model/modelIngreso.php';
require_once __DIR__ . '/../model/modelGastos.php';

$modeloIngreso = new ModeloIngreso();
$modeloGasto = new ModeloGasto();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        // ----- INGRESOS -----
        case 'addIncome':
            $month = $_POST['month'] ?? '';
            $year = $_POST['year'] ?? '';
            $amount = $_POST['amount'] ?? '';

            if (!empty($month) && !empty($year) && is_numeric($amount) && $amount >= 0) {
                $existe = $modeloIngreso->existeIngreso($month, $year);
                if ($existe) {
                    header('Location: ../index.php?status=error');
                } else {
                    $resultado = $modeloIngreso->addOrUpdateIncome($month, $year, $amount);
                    $estado = $resultado === 'actualizado' ? 'updated' : 'success';
                    header("Location: ../index.php?status=$estado");
                }
            } else {
                header('Location: ../index.php?status=error');
            }
            break;

        case 'updateIncome':
            $idIncome = $_POST['idIncome'] ?? '';
            $amount = $_POST['amount'] ?? '';

            if (is_numeric($idIncome) && is_numeric($amount) && $amount >= 0) {
                $modeloIngreso->updateIncome($idIncome, $amount);
                header('Location: ../index.php?status=updated');
            } else {
                header('Location: ../index.php?status=error');
            }
            break;

        case 'deleteIncome':
            $idIncome = $_POST['idIncome'] ?? '';

            if (is_numeric($idIncome)) {
                $modeloIngreso->deleteIncome($idIncome);
                header('Location: ../index.php?status=deleted');
            } else {
                header('Location: ../index.php?status=error');
            }
            break;

        case 'addAmount':
            $idIncome = $_POST['idIncome'] ?? '';
            $amount = $_POST['amount'] ?? '';

            if (is_numeric($idIncome) && is_numeric($amount) && $amount >= 0) {
                $modeloIngreso->addAmount($idIncome, $amount);
                header('Location: ../index.php?status=updated');
            } else {
                header('Location: ../index.php?status=error');
            }
            break;

        // ----- GASTOS -----
        case 'addBill':
            $amount = $_POST['amount'] ?? 0;
            $categoryId = $_POST['categoryId'] ?? 0;
            $month = $_POST['month'] ?? '';
            $year = $_POST['year'] ?? '';

            if (is_numeric($amount) && is_numeric($categoryId) && !empty($month) && !empty($year)) {
                $modeloGasto->addBill($amount, $categoryId, $month, $year);
                header('Location: ../gastos.php?status=success');
            } else {
                header('Location: ../gastos.php?status=error');
            }
            break;

        case 'updateBill':
            $idBill = $_POST['idBill'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $categoryId = $_POST['categoryId'] ?? 0;

            if (is_numeric($idBill) && is_numeric($amount) && is_numeric($categoryId)) {
                $modeloGasto->updateBill($idBill, $amount, $categoryId);
                header('Location: ../gastos.php?status=updated');
            } else {
                header('Location: ../gastos.php?status=error');
            }
            break;

        case 'deleteBill':
            $idBill = $_POST['idBill'] ?? 0;

            if (is_numeric($idBill)) {
                $modeloGasto->deleteBill($idBill);
                header('Location: ../gastos.php?status=deleted');
            } else {
                header('Location: ../gastos.php?status=error');
            }
            break;

        // Acción no válida
        default:
            header('Location: ../index.php?status=error');
            break;
    }

    exit;
}
