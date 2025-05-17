<?php

namespace app\controllers;

use app\models\entities\Mesa;

class MesasController{

    public function queryAllMesas(){
        $mesa = new Mesa();
        $data = $mesa->all();
        return $data;
    }

    public function saveNewMesa($request){
        $mesa = new Mesa();
        $mesa->set('name', $request['nombreInput']);
        return $mesa->save();
    }

    public function updateMesa($request){
        $mesa = new Mesa();
        $mesa->set('id', $request['idInput']);
        $mesa->set('name', $request['nombreInput']);
        return $mesa->update();
    }

    public function deleteMesa($id){
        $mesa = new Mesa();
        $mesa->set('id', $id);
        
        // Verificar si la mesa tiene relaciones
        if($mesa->tieneRelaciones()){
            return false;
        }
        
        return $mesa->delete();
    }

    public function getMesaById($id){
        $mesa = new Mesa();
        if($mesa->getById($id)){
            return $mesa;
        }
        return null;
    }
}