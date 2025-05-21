<?php

namespace app\controller;

use app\model\entities\Income;


class IncomeController
{

    public function queryAllIncome()
    {
        $income = new Income();
        $data = $income->all();
        return $data;
    }

    public function saveNewIncome($request)
    {
        $income = new Income();
        $income->set('value', $request['valueInput']);
        $income->set('idReport', $request['idReportInput']);
        return $income->save();
    }

    public function updateIncome($request)
    {
        $income = new Income();
        $income->set('id', $request['idInput']);
        $income->set('value', $request['valueInput']);
        // NO se cambia idReport, ya que no se modifica mes ni año
        return $income->update();
    }
    
}