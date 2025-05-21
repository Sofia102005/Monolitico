<?php

namespace app\model\entities;

use app\model\conexionDB\Conexion;

class Categories extends Entity
{
    protected $id = "";
    protected $name = "";
    protected $percentage = null;

    public function all()
    {
        $sql = "SELECT * FROM categories";
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $categories = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $category = new Categories();
                $category->set('id', $rowDb['id']);
                $category->set('name', $rowDb['name']);
                $category->set('percentage', $rowDb['percentage']);
                array_push($categories, $category);
            }
        }
        $conex->close();
        return $categories; 
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
        $sql = "UPDATE categories SET name='" . $this->name . "', percentage=" . $this->percentage . " WHERE id=" . $this->id;
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function delete()
    {
        $sql = "DELETE FROM categories WHERE id=" . $this->id;
        $conex = new Conexion();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }
}