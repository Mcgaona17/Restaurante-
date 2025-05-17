<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Plato extends Entity{
    protected $id = null;
    protected $description = "";
    protected $price = 0;
    protected $idCategory = null;
    protected $categoryName = ""; // Para almacenar el nombre de la categoría

    public function all(){
        $sql = "SELECT d.*, c.name as categoryName FROM dishes d ";
        $sql .= "JOIN categories c ON d.idCategory = c.id";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $platos = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $plato = new Plato();
                $plato->set('id', $rowDb['id']);
                $plato->set('description', $rowDb['description']);
                $plato->set('price', $rowDb['price']);
                $plato->set('idCategory', $rowDb['idCategory']);
                $plato->set('categoryName', $rowDb['categoryName']);
                array_push($platos, $plato);
            }
        }

        $conex->close();
        return $platos;
    }

    public function save(){
        $sql = "INSERT INTO dishes (description, price, idCategory) VALUES";
        $sql .= "('" . $this->description . "', " . $this->price . ", " . $this->idCategory . ")";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function update(){
        $sql = "UPDATE dishes SET ";
        $sql .= "description='" . $this->description . "', ";
        $sql .= "price=" . $this->price . " ";
        $sql .= "WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function delete(){
        $sql = "DELETE FROM dishes WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    // Verificar si el plato tiene detalles de orden asociados
    public function tieneRelaciones(){
        $sql = "SELECT COUNT(*) as total FROM order_details WHERE idDish=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $row = $resultDb->fetch_assoc();
        $conex->close();
        return ($row['total'] > 0);
    }

    // Obtener un plato por ID
    public function getById($id){
        $sql = "SELECT d.*, c.name as categoryName FROM dishes d ";
        $sql .= "JOIN categories c ON d.idCategory = c.id ";
        $sql .= "WHERE d.id=" . $id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        
        if($resultDb->num_rows > 0){
            $rowDb = $resultDb->fetch_assoc();
            $this->set('id', $rowDb['id']);
            $this->set('description', $rowDb['description']);
            $this->set('price', $rowDb['price']);
            $this->set('idCategory', $rowDb['idCategory']);
            $this->set('categoryName', $rowDb['categoryName']);
            $conex->close();
            return true;
        }
        
        $conex->close();
        return false;
    }

    // Obtener platos por categoría
    public function getByCategory($idCategory){
        $sql = "SELECT * FROM dishes WHERE idCategory=" . $idCategory;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $platos = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $plato = new Plato();
                $plato->set('id', $rowDb['id']);
                $plato->set('description', $rowDb['description']);
                $plato->set('price', $rowDb['price']);
                $plato->set('idCategory', $rowDb['idCategory']);
                array_push($platos, $plato);
            }
        }

        $conex->close();
        return $platos;
    }

    // Obtener ranking de platos más vendidos
    public function getPlatosMasVendidos($fechaInicio, $fechaFin){
        $sql = "SELECT d.id, d.description, SUM(od.quantity) as total_vendido ";
        $sql .= "FROM dishes d ";
        $sql .= "JOIN order_details od ON d.id = od.idDish ";
        $sql .= "JOIN orders o ON od.idOrder = o.id ";
        $sql .= "WHERE o.dateOrder BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        $sql .= "AND o.anulada = 0 ";
        $sql .= "GROUP BY d.id ";
        $sql .= "ORDER BY total_vendido DESC";
        
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ranking = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $ranking[] = [
                    'id' => $rowDb['id'],
                    'description' => $rowDb['description'],
                    'total_vendido' => $rowDb['total_vendido']
                ];
            }
        }

        $conex->close();
        return $ranking;
    }
}