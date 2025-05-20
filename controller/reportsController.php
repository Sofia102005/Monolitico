<?php

namespace app\controller;

use app\model\entities\Reports;

class ReportsController
{

    public function queryAllReports()
    {
        $date = new Reports();
        $data = $date->all();
        return $data;
    }

    public function saveNewReports($request)
    {
        $person = new Reports();
        $person->set('month', $request['monthInput']);
        $person->set('year', $request['yearInput']);
        return $person->save();
    }
}