<?php

namespace app\controllers;

use app\models\entities\Plato;

class PlatosController{

    public function queryAllPlatos(){
        $plato = new Plato();
        $data = $plato->all();
        return $data;
    }

    public function saveNewPlato($request){
        $plato = new Plato();
        $plato->set('description', $request['descripcionInput']);
        $plato->set('price', $request['precioInput']);
        $plato->set('idCategory', $request['categoriaInput']);
        return $plato->save();
    }

    public function updatePlato($request){
        $plato = new Plato();
        $plato->set('id', $request['idInput']);
        $plato->set('description', $request['descripcionInput']);
        $plato->set('price', $request['precioInput']);
        return $plato->update();
    }

    public function deletePlato($id){
        $plato = new Plato();
        $plato->set('id', $id);
        
        // Verificar si el plato tiene relaciones
        if($plato->tieneRelaciones()){
            return false;
        }
        
        return $plato->delete();
    }

    public function getPlatoById($id){
        $plato = new Plato();
        if($plato->getById($id)){
            return $plato;
        }
        return null;
    }

    public function getPlatosByCategoria($idCategoria){
        $plato = new Plato();
        return $plato->getByCategory($idCategoria);
    }

    public function getPlatosMasVendidos($fechaInicio, $fechaFin){
        $plato = new Plato();
        return $plato->getPlatosMasVendidos($fechaInicio, $fechaFin);
    }
}