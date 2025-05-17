
<?php

namespace app\models\drivers;

use mysqli;

class ConexDB {

    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $nameDB = "proyecto_2_db";
    private $conex = null;

    public function __construct() //abrir base de datos
    {
        $this -> conex = new mysqli(
            $this -> host,
            $this -> user,
            $this -> pwd,
            $this -> nameDB
        );
    }

    public function execSQL($sql){ //ejecutar base de datos
        return $this -> conex -> query($sql);
    }

    public function close(){ //cerrar base de datos
        $this -> conex -> close();
    }

    // Método para obtener el último ID insertado
    public function lastInsertId(){
        return $this->conex->insert_id;
    }
}