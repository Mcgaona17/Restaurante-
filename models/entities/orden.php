<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Orden extends Entity{
    protected $id = null;
    protected $dateOrder = "";
    protected $total = 0;
    protected $idTable = null;
    protected $anulada = 0;
    protected $tableName = ""; // Para almacenar el nombre de la mesa

    public function all(){
        $sql = "SELECT o.*, t.name as tableName FROM orders o ";
        $sql .= "JOIN restaurant_tables t ON o.idTable = t.id ";
        $sql .= "ORDER BY o.dateOrder DESC";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ordenes = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $orden = new Orden();
                $orden->set('id', $rowDb['id']);
                $orden->set('dateOrder', $rowDb['dateOrder']);
                $orden->set('total', $rowDb['total']);
                $orden->set('idTable', $rowDb['idTable']);
                $orden->set('tableName', $rowDb['tableName']);
                $orden->set('anulada', isset($rowDb['anulada']) ? $rowDb['anulada'] : 0);
                array_push($ordenes, $orden);
            }
        }

        $conex->close();
        return $ordenes;
    }

    public function save(){
        $sql = "INSERT INTO orders (dateOrder, total, idTable, anulada) VALUES";
        $sql .= "('" . $this->dateOrder . "', " . $this->total . ", " . $this->idTable . ", 0)";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $lastId = $conex->lastInsertId();
        $conex->close();
        
        // Devolver el ID de la orden insertada
        if($resultDb) {
            return $lastId;
        }
        return false;
    }

    public function update(){
        // No permitimos actualizar órdenes, solo anularlas
        return false;
    }

    public function delete(){
        // No permitimos eliminar órdenes, solo anularlas
        return false;
    }

    // Anular una orden
    public function anular(){
        $sql = "UPDATE orders SET anulada = 1 WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    // Obtener órdenes por rango de fechas (no anuladas)
    public function getOrdenesEnRango($fechaInicio, $fechaFin){
        $sql = "SELECT o.*, t.name as tableName FROM orders o ";
        $sql .= "JOIN restaurant_tables t ON o.idTable = t.id ";
        $sql .= "WHERE o.dateOrder BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        $sql .= "AND o.anulada = 0 ";
        $sql .= "ORDER BY o.dateOrder DESC";
        
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ordenes = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $orden = new Orden();
                $orden->set('id', $rowDb['id']);
                $orden->set('dateOrder', $rowDb['dateOrder']);
                $orden->set('total', $rowDb['total']);
                $orden->set('idTable', $rowDb['idTable']);
                $orden->set('tableName', $rowDb['tableName']);
                $orden->set('anulada', isset($rowDb['anulada']) ? $rowDb['anulada'] : 0);
                array_push($ordenes, $orden);
            }
        }

        $conex->close();
        return $ordenes;
    }

    // Obtener órdenes anuladas por rango de fechas
    public function getOrdenesAnuladasEnRango($fechaInicio, $fechaFin){
        $sql = "SELECT o.*, t.name as tableName FROM orders o ";
        $sql .= "JOIN restaurant_tables t ON o.idTable = t.id ";
        $sql .= "WHERE o.dateOrder BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        $sql .= "AND o.anulada = 1 ";
        $sql .= "ORDER BY o.dateOrder DESC";
        
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ordenes = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $orden = new Orden();
                $orden->set('id', $rowDb['id']);
                $orden->set('dateOrder', $rowDb['dateOrder']);
                $orden->set('total', $rowDb['total']);
                $orden->set('idTable', $rowDb['idTable']);
                $orden->set('tableName', $rowDb['tableName']);
                $orden->set('anulada', $rowDb['anulada']);
                array_push($ordenes, $orden);
            }
        }

        $conex->close();
        return $ordenes;
    }

    // Obtener una orden por ID
    public function getById($id){
        $sql = "SELECT o.*, t.name as tableName FROM orders o ";
        $sql .= "JOIN restaurant_tables t ON o.idTable = t.id ";
        $sql .= "WHERE o.id=" . $id;
        
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        
        if($resultDb->num_rows > 0){
            $rowDb = $resultDb->fetch_assoc();
            $this->set('id', $rowDb['id']);
            $this->set('dateOrder', $rowDb['dateOrder']);
            $this->set('total', $rowDb['total']);
            $this->set('idTable', $rowDb['idTable']);
            $this->set('tableName', $rowDb['tableName']);
            $this->set('anulada', isset($rowDb['anulada']) ? $rowDb['anulada'] : 0);
            $conex->close();
            return true;
        }
        
        $conex->close();
        return false;
    }

    // Calcular el total general de órdenes en un rango de fechas
    public function calcularTotalOrdenes($fechaInicio, $fechaFin, $anuladas = false){
        $sql = "SELECT SUM(total) as total_general FROM orders ";
        $sql .= "WHERE dateOrder BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        $sql .= "AND anulada = " . ($anuladas ? '1' : '0');
        
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $row = $resultDb->fetch_assoc();
        $conex->close();
        
        return $row['total_general'] ? $row['total_general'] : 0;
    }
}