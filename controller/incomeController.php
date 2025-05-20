<?php

namespace app\controller;

use app\model\entities\Incomes;

class IncomeController
{

    public function queryAllIncome()
    {
        $income = new Incomes();
        $data = $income->all();
        return $data;
    }

    public function saveNewIncome($request)
    {
        $income = new Incomes();
        $income->set('value', $request['valueInput']);
        $income->set('idReport', $request['idReportInput']);
        return $income->save();
    }

    public function updateIncome($request)
    {
        $income = new Incomes();
        $income->set('id', $request['idInput']);
        $income->set('value', $request['valueInput']);
        $income->set('idReport', $request['idReportInput']);
        return $person->update();
    }
}