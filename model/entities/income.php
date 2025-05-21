<?php

namespace app\model\entities;

require_once __DIR__ . '/../conexionDB/Conexion.php';

use app\model\conexionDB\Conexion;


class Income extends Entity
{
    protected $id = null;
    protected $value = null;
    protected $idReport = null;

    public function all()
    {
        $sql = "select income.*, reports.month, reports.year from income inner join reports on income.idReport=reports.id";
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $incomes = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $income = new Income();
                $income->set('id', $rowDb['id']);
                $income->set('value', $rowDb['value']);
                $income->set('idReport', $rowDb['idReport']); // <-- agregar esta línea
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
        $conex = new Conexion();
    
        // Verificar si ya existe un ingreso con el mismo idReport
        $checkSql = "SELECT id FROM income WHERE idReport = '" . $this->idReport . "'";
        $checkResult = $conex->execSQL($checkSql);
        if ($checkResult->num_rows > 0) {
            $conex->close();
            die("Error: Ya existe un ingreso registrado para este mes y año.");
        }
    
        // Verificar si el valor es mayor o igual a cero
        if ($this->value < 0) {
            $conex->close();
            die("Error: El valor del ingreso no puede ser menor a cero.");
        }
    
        $sql = "INSERT INTO income (value, idReport) VALUES ('" . $this->value . "', '" . $this->idReport . "')";
        $resultDb = $conex->execSQL($sql);
        $conex->close();
    
        return $resultDb;
    }
    
    public function update()
    {
        $sql = "UPDATE income SET value='" . $this->value . "' WHERE id=" . $this->id;
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }
    
    public function delete(){

    }

}