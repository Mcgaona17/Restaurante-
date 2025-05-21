<?php
namespace app\models\entities;

use app\models\drivers\ConexDB;

class Reporte {

    public function getOrdenesActivasPorFechas($inicio, $fin) {
        $sql = "SELECT o.id, o.fecha, t.name as mesa, o.total 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                WHERE o.fecha BETWEEN '$inicio' AND '$fin' AND o.anulada = 0";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ordenes = [];

        if ($resultDb->num_rows > 0) {
            while ($row = $resultDb->fetch_assoc()) {
                $ordenes[] = $row;
            }
        }
        $conex->close();
        return $ordenes;
    }

    public function getTotalActivoPorFechas($inicio, $fin) {
        $sql = "SELECT SUM(total) AS total FROM orders 
                WHERE fecha BETWEEN '$inicio' AND '$fin' AND anulada = 0";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $total = 0;

        if ($row = $resultDb->fetch_assoc()) {
            $total = $row['total'];
        }
        $conex->close();
        return $total;
    }

    public function getRankingPlatos($inicio, $fin) {
        $sql = "SELECT d.description, SUM(od.cantidad) as cantidad
                FROM order_details od
                JOIN dishes d ON od.idDish = d.id
                JOIN orders o ON od.idOrder = o.id
                WHERE o.fecha BETWEEN '$inicio' AND '$fin' AND o.anulada = 0
                GROUP BY d.description
                ORDER BY cantidad DESC";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ranking = [];

        if ($resultDb->num_rows > 0) {
            while ($row = $resultDb->fetch_assoc()) {
                $ranking[] = $row;
            }
        }
        $conex->close();
        return $ranking;
    }

    public function getOrdenesAnuladasPorFechas($inicio, $fin) {
        $sql = "SELECT o.id, o.fecha, t.name as mesa, o.total 
                FROM orders o 
                JOIN restaurant_tables t ON o.idTable = t.id 
                WHERE o.fecha BETWEEN '$inicio' AND '$fin' AND o.anulada = 1";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ordenes = [];

        if ($resultDb->num_rows > 0) {
            while ($row = $resultDb->fetch_assoc()) {
                $ordenes[] = $row;
            }
        }
        $conex->close();
        return $ordenes;
    }

    public function getTotalAnuladoPorFechas($inicio, $fin) {
        $sql = "SELECT SUM(total) AS total FROM orders 
                WHERE fecha BETWEEN '$inicio' AND '$fin' AND anulada = 1";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $total = 0;

        if ($row = $resultDb->fetch_assoc()) {
            $total = $row['total'];
        }
        $conex->close();
        return $total;
    }
}
