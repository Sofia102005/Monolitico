<?php

namespace app\model\entities;

use app\model\conexionDB\Conexion;


class Incomes extends Entity
{
    protected $id = null;
    protected $values = null;
    protected $idReport = null;

    public function all()
    {
        $sql = "select income.*, reports.month, reports.year from income inner join reports on income.idReport=reports.id";
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $incomes = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $income = new Incomes();
                $income->set('id', $rowDb['id']);
                $income->set('value', $rowDb['value']);
                $income->set('month', $rowDb['month']);
                $income->set('year', $rowDb['year']);
                array_push($incomes, $income);
            }
        }
        $conex->close();
        return $incomes;
    }

    public function save()
    {
        $sql = "insert into income (values,idReport) values ";
        $sql .= "('" . $this->values . "','" . $this->idReport . "')";
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function update()
    {
        $sql = "update income set ";
        $sql .= "values='" . $this->value . "',";
        $sql .= "idReport='" . $this->idReport . "',";
        $sql .= " where id=" . $this->id;
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }
    public function delete(){

    }

}