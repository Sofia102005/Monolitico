<?php

namespace app\controller;

use app\model\entities\Categories;
use mysqli_sql_exception;

class CategoriesController
{
    public function queryAllCategories()
    {
        $category = new Categories();
        return $category->all();
    }

    public function saveNewCategory(array $request)
    {
        $category = new Categories();
        $category->set('name', $request['nameInput']);
        $category->set('percentage', $request['percentageInput']);
        return $category->save();
    }

    public function updateCategory(array $request)
    {
        $category = new Categories();
        $category->set('id', $request['idInput']);
        $category->set('name', $request['nameInput']);
        $category->set('percentage', $request['percentageInput']);
        return $category->update();
    }

    public function deleteCategory($idCategory)
    {
        $category = new Categories();
        $category->set('idCategory', $idCategory);

        try {
            $result = $category->delete();
            if ($result) {
                return "Categoría eliminada correctamente.";
            } else {
                return "No se pudo eliminar la categoría.";
            }
        } catch (mysqli_sql_exception $message) {
            if (str_contains($message->getMessage(), 'foreign key constraint fails')) {
                return "No se puede eliminar la categoría porque está relacionada con otros registros.";
            } else {
                return "Error al eliminar la categoría: " . $message->getMessage();
            }
        }
    }
}
