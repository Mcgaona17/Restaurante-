
<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Mesa extends Entity{
    protected $id = null;
    protected $name = "";

    public function all(){
        $sql = "SELECT * FROM restaurant_tables";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $mesas = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $mesa = new Mesa();
                $mesa->set('id', $rowDb['id']);
                $mesa->set('name', $rowDb['name']);
                array_push($mesas, $mesa);
            }
        }

        $conex->close();
        return $mesas;
    }

    public function save(){
        $sql = "INSERT INTO restaurant_tables (name) VALUES";
        $sql .= "('" . $this->name . "')";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function update(){
        $sql = "UPDATE restaurant_tables SET ";
        $sql .= "name='" . $this->name . "' ";
        $sql .= "WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function delete(){
        $sql = "DELETE FROM restaurant_tables WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    // Verificar si la mesa tiene órdenes asociadas
    public function tieneRelaciones(){
        $sql = "SELECT COUNT(*) as total FROM orders WHERE idTable=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $row = $resultDb->fetch_assoc();
        $conex->close();
        return ($row['total'] > 0);
    }

    // Obtener una mesa por ID
    public function getById($id){
        $sql = "SELECT * FROM restaurant_tables WHERE id=" . $id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        
        if($resultDb->num_rows > 0){
            $rowDb = $resultDb->fetch_assoc();
            $this->set('id', $rowDb['id']);
            $this->set('name', $rowDb['name']);
            $conex->close();
            return true;
        }
        
        $conex->close();
        return false;
    }
}

