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
        $report = new Reports();
        $report->set('month', $request['monthInput']);
        $report->set('year', $request['yearInput']);
        return $report->save();
    }
}