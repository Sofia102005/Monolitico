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

    public function createCategory($name, $percentage)
    {
        $category = new Categories();
        $category->set('name', $name);
        $category->set('percentage', $percentage);
        return $category->save();
    }

    public function updateCategory($id, $name, $percentage)
    {
        $category = new Categories();
        $category->set('id', $id);
        $category->set('name', $name);
        $category->set('percentage', $percentage);
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
