<?php

namespace app\controller;

use app\model\entities\Categories;
use mysqli_sql_exception;

class CategoriesController
{
    public function queryAllCategories()
    {
        $category = new Categories();
        $data = $category->all();
        return $data;
    }

    public function saveNewCategory($request)
    {
        $category = new Categories();
        $category->set('name', $request['nameInput']);
        $category->set('percentage', $request['percentageInput']);
        return $category->save();
    }

    public function updateCategory($request)
    {
        $category = new Categories();
        $category->set('id', $request['idInput']);
        $category->set('name', $request['nameInput']);
        $category->set('percentage', $request['percentageInput']);
        return $category->update();
    }




    public function deleteCategory($idCategory){
        $category = new Categories();
        $category->set('idCategory', $idCategory);

        try {
            $result = $category->delete();
            if ($result) {
                return "Mesa eliminada correctamente.";
            } else {
                return "No se pudo eliminar la mesa.";
            }
        } catch (mysqli_sql_exception $message) {
            if (str_contains($message->getMessage(), 'foreign key constraint fails')) {
                return "No se puede eliminar la categoria porque está relacionada con otros registros.";
            }
        }
    }
    
}