<?php

namespace app\model\entities;

use app\model\conexionDB\Conexion ;

class categories extends Entity
{
    protected $id = "";
    protected $name = "";
    protected $percentage = null;

    public function all()
    {
        $sql = "select * from categories";
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $categories = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $category = new categories();
                $category->set('id', $rowDb['id']);
                $category->set('name', $rowDb['name']);
                $category->set('percentage', $rowDb['percentage']);
                array_push($categories, $category);
            }
        }
        $conex->close();
        return $category;
    }

    public function save()
    {
        $sql = "INSERT INTO categories (name, percentage) VALUES ('" . $this->name . "', '" . $this->percentage . "')";
        $conex = new Conexion();
        
        $resultDb = $conex->execSQL($sql);
            $conex->close();
            return $resultDb;
    }
    
    public function update()
    {
        $sql = "UPDATE categories SET name='" . $this->name . "', percentaje=". $this->percentage." . WHERE id=" . $this->id;
        $conex = new conexion();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }
    public function delete()
    {
        $sql = "delete from categories where id=" . $this->id;
        $conecction = new conexion();
        $resultDB = $conecction->execSQL($sql);
        $conecction->close();
        return $resultDB;
    }

}