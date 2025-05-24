<?php

namespace app\controllers;

use app\models\entities\Orden;
use app\models\entities\DetalleOrden;

class OrdenesController{

    public function queryAllOrdenes(){
        $orden = new Orden();
        $data = $orden->all();
        return $data;
    }

    public function saveNewOrden($request, $detalles){
        // Crear una nueva orden
        $orden = new Orden();
        $orden->set('dateOrder', $request['fechaInput']);
        $orden->set('total', $request['totalInput']);
        $orden->set('idTable', $request['mesaInput']);
        
        // Guardar la orden y obtener su ID
        $idOrden = $orden->save();
        
        if($idOrden){
            // Guardar cada detalle de la orden
            foreach($detalles as $detalle){
                $detalleOrden = new DetalleOrden();
                $detalleOrden->set('quantity', $detalle['cantidad']);
                $detalleOrden->set('price', $detalle['precio']);
                $detalleOrden->set('idOrder', $idOrden);
                $detalleOrden->set('idDish', $detalle['idPlato']);
                $detalleOrden->save();
            }
            
            return $idOrden;
        }
        
        return false;
    }

    public function anularOrden($id){
        $orden = new Orden();
        $orden->set('id', $id);
        return $orden->anular();
    }

   public function getOrdenById($id){
    $orden = new Orden();
    if ($orden->getById($id)) {
        $detalles = $this->getDetallesByOrdenId($id); // cargamos los detalles
        $orden->set("detalles", $detalles);           // los asignamos
        return $orden;
    }
    return null;
}

    public function getDetallesByOrdenId($idOrden){
        $detalleOrden = new DetalleOrden();
        return $detalleOrden->getDetallesByOrdenId($idOrden);
    }

    public function getOrdenesEnRango($fechaInicio, $fechaFin){
        $orden = new Orden();
        return $orden->getOrdenesEnRango($fechaInicio, $fechaFin);
    }

    public function getOrdenesAnuladasEnRango($fechaInicio, $fechaFin){
        $orden = new Orden();
        return $orden->getOrdenesAnuladasEnRango($fechaInicio, $fechaFin);
    }

    public function calcularTotalOrdenes($fechaInicio, $fechaFin, $anuladas = false){
        $orden = new Orden();
        return $orden->calcularTotalOrdenes($fechaInicio, $fechaFin, $anuladas);
    }
}