<?php

namespace app\controller;

use app\model\entities\ModeloGasto;
use mysqli_sql_exception;

class ModeloGastoController
{
    public function queryAllBills(): array
    {
        $gasto = new ModeloGasto();
        return $gasto->getAllBills();
    }

    public function saveNewBill(array $request): bool|string
    {
        $gasto = new ModeloGasto();
        $gasto->set('value', $request['valueInput']);
        $gasto->set('month', $request['monthInput']);
        $gasto->set('year', $request['yearInput']);
        $gasto->set('categoryId', $request['categoryInput']);

        return $gasto->save();
    }

    public function updateBill(array $request): bool|string
    {
        $gasto = new ModeloGasto();
        $gasto->set('id', $request['idInput']);
        $gasto->set('value', $request['valueInput']);
        $gasto->set('month', $request['monthInput']);
        $gasto->set('year', $request['yearInput']);
        $gasto->set('categoryId', $request['categoryInput']);

        return $gasto->update();
    }

    public function deleteBill(int $id): string
    {
        $gasto = new ModeloGasto();
        $gasto->set('id', $id);

        try {
            $result = $gasto->delete();
            return $result ? "Gasto eliminado correctamente." : "No se pudo eliminar el gasto.";
        } catch (mysqli_sql_exception $e) {
            if (str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return "No se puede eliminar el gasto porque está relacionado con otros registros.";
            }
            return "Error al eliminar el gasto: " . $e->getMessage();
        }
    }

    public function queryBillsByMonthAndYear(int $month, int $year): array
    {
        $gasto = new ModeloGasto();
        return $gasto->getBillsByMonth($month, $year);
    }
}