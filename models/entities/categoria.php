<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Categoria extends Entity{
    protected $id = null;
    protected $name = "";

    public function all(){
        $sql = "SELECT * FROM categories";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $categorias = [];

        if($resultDb->num_rows > 0){
            while($rowDb = $resultDb->fetch_assoc()){
                $categoria = new Categoria();
                $categoria->set('id', $rowDb['id']);
                $categoria->set('name', $rowDb['name']);
                array_push($categorias, $categoria);
            }
        }

        $conex->close();
        return $categorias;
    }

    public function save(){
        $sql = "INSERT INTO categories (name) VALUES";
        $sql .= "('" . $this->name . "')";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function update(){
        $sql = "UPDATE categories SET ";
        $sql .= "name='" . $this->name . "' ";
        $sql .= "WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function delete(){
        $sql = "DELETE FROM categories WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    // Verificar si la categoría tiene platos asociados
    public function tieneRelaciones(){
        $sql = "SELECT COUNT(*) as total FROM dishes WHERE idCategory=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $row = $resultDb->fetch_assoc();
        $conex->close();
        return ($row['total'] > 0);
    }

    // Obtener una categoría por ID
    public function getById($id){
        $sql = "SELECT * FROM categories WHERE id=" . $id;
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