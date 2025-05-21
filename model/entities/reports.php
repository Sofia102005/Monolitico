<?php

namespace app\model\entities;

use app\model\conexionDB\Conexion ;

class Reports extends Entity
{
    protected $id = "";
    protected $month = "";
    protected $year = null;

    public function all()
    {
        $sql = "select * from reports";
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $datos = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $report = new Reports();
                $report->set('id', $rowDb['id']);
                $report->set('month', $rowDb['month']);
                $report->set('year', $rowDb['year']);
                array_push($datos, $report);
            }
        }
        $conex->close();
        return $report;
    }

    public function save()
    {
        $sql = "INSERT INTO reports (month, year) VALUES ('" . $this->month . "', '" . $this->year . "')";
        $conex = new Conexion();
        
        $resultDb = $conex->execSQL($sql);
    
        if ($resultDb) {
            // Obtener el ID insertado
            $insertedId = $conex->getConnection()->insert_id;
            $conex->close();
            return $insertedId;
        } else {
            $conex->close();
            return false;
        }
    }
    
    public function update(){}
    public function delete(){}

}