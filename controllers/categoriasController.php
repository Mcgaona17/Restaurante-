<?php

namespace app\controllers;

use app\models\entities\Categoria;

class CategoriasController{

    public function queryAllCategorias(){
        $categoria = new Categoria();
        $data = $categoria->all();
        return $data;
    }

    public function saveNewCategoria($request){
        $categoria = new Categoria();
        $categoria->set('name', $request['nombreInput']);
        return $categoria->save();
    }

    public function updateCategoria($request){
        $categoria = new Categoria();
        $categoria->set('id', $request['idInput']);
        $categoria->set('name', $request['nombreInput']);
        return $categoria->update();
    }

    public function deleteCategoria($id){
        $categoria = new Categoria();
        $categoria->set('id', $id);
        
        // Verificar si la categoría tiene relaciones
        if($categoria->tieneRelaciones()){
            return false;
        }
        
        return $categoria->delete();
    }

    public function getCategoriaById($id){
        $categoria = new Categoria();
        if($categoria->getById($id)){
            return $categoria;
        }
        return null;
    }
}
