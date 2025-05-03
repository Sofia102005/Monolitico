<?php
require_once __DIR__ . '/../model/modelIngreso.php';

$modelo = new ModeloIngreso();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'addIncome') {
        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';
        $amount = $_POST['amount'] ?? '';
        
        if (!empty($month) && !empty($year) && is_numeric($amount) && $amount >= 0) {
            $resultado = $modelo->addIncome($month, $year, $amount);
            if ($resultado === 'nuevo') {
                header('Location: ../index.php?status=success');
            } else {
                echo $resultado;
                exit;
            }
        } else {
            echo "Error: Los datos ingresados no son válidos.";
            exit;
        }
        exit;
    }
    }
    if ($action === 'updateIncome') {
        $idIncome = $_POST['idIncome'] ?? '';
        $amount = $_POST['amount'] ?? '';

        if (is_numeric($idIncome) && is_numeric($amount) && $amount >= 0) {
            $modelo->updateIncome($idIncome, $amount);
            header('Location: ../index.php?status=updated');
        } else {
            header('Location: ../index.php?status=error');
        }
        exit;
    }

    if ($action === 'deleteIncome') {
        $idIncome = $_POST['idIncome'] ?? '';

        if (is_numeric($idIncome)) {
            $modelo->deleteIncome($idIncome);
            header('Location: ../index.php?status=deleted');
        } else {
            header('Location: ../index.php?status=error');
        }
        exit;
    }

    if ($action === 'addAmount') {
        $idIncome = $_POST['idIncome'] ?? '';
        $amount = $_POST['amount'] ?? '';

        if (is_numeric($idIncome) && is_numeric($amount) && $amount >= 0) {
            $modelo->addAmount($idIncome, $amount);
            header('Location: ../index.php?status=updated');
        } else {
            header('Location: ../index.php?status=error');
        }
        exit;
    }

    if ($action === 'addBill') {
        $description = $_POST['description'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $categoryId = $_POST['categoryId'] ?? 0;
        $reportId = $_POST['reportId'] ?? 0;

        if (!empty($description) && is_numeric($amount) && is_numeric($categoryId) && is_numeric($reportId)) {
            $modelo->addBill($description, $amount, $categoryId, $reportId);
            header('Location: ../index.php?status=success');
        } else {
            header('Location: ../index.php?status=error');
        }
        exit;
    }

    if ($action === 'updateBill') {
        $id = $_POST['id'] ?? 0;
        $description = $_POST['description'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $categoryId = $_POST['categoryId'] ?? 0;

        if (is_numeric($id) && !empty($description) && is_numeric($amount) && is_numeric($categoryId)) {
            $modelo->updateBill($id, $description, $amount, $categoryId);
            header('Location: ../index.php?status=updated');
        } else {
            header('Location: ../index.php?status=error');
        }
        exit;
    }

    if ($action === 'deleteBill') {
        $id = $_POST['id'] ?? 0;

        if (is_numeric($id)) {
            $modelo->deleteBill($id);
            header('Location: ../index.php?status=deleted');
        } else {
            header('Location: ../index.php?status=error');
        }
        exit;
    }

   
    header('Location: ../index.php?status=error');
    exit;
