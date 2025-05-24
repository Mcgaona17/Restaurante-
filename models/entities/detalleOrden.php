<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class DetalleOrden extends Entity {
    protected $id = null;
    protected $quantity = 0;
    protected $price = 0;
    protected $idOrder = null;
    protected $idDish = null;
    protected $dishDescription = ""; // ✅ nombre del plato para mostrar

    public function all() {
        // No se utiliza directamente, siempre se obtienen los detalles a través de una orden
        return [];
    }

    public function save() {
        $sql = "INSERT INTO order_details (quantity, price, idOrder, idDish) VALUES";
        $sql .= "(" . $this->quantity . ", " . $this->price . ", " . $this->idOrder . ", " . $this->idDish . ")";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function update() {
        // No se permite actualizar detalles de órdenes
        return false;
    }

    public function delete() {
        // No se permite eliminar detalles de órdenes
        return false;
    }

    // Obtener los detalles de una orden específica
    public function getDetallesByOrdenId($idOrden) {
        $sql = "SELECT od.*, d.description as dishDescription FROM order_details od ";
        $sql .= "JOIN dishes d ON od.idDish = d.id ";
        $sql .= "WHERE od.idOrder = " . $idOrden;

        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $detalles = [];

        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $detalle = new DetalleOrden();
                $detalle->set('id', $rowDb['id']);
                $detalle->set('quantity', $rowDb['quantity']);
                $detalle->set('price', $rowDb['price']);
                $detalle->set('idOrder', $rowDb['idOrder']);
                $detalle->set('idDish', $rowDb['idDish']);
                $detalle->set('dishDescription', $rowDb['dishDescription']); // ✅ nombre del plato
                array_push($detalles, $detalle);
            }
        }

        $conex->close();
        return $detalles;
    }

    // Calcular el subtotal de un detalle
    public function calcularSubtotal() {
        return $this->quantity * $this->price;
    }
}
