<?php
namespace app\controllers;

use app\models\entities\Reporte;

class ReportesController {

    public function index() {
        include "views/reportes.php";
    }

    public function verActivos() {
        $reporte = new Reporte();
        $ordenes = $reporte->getOrdenesActivasPorFechas($_POST['fecha_inicio'], $_POST['fecha_fin']);
        $total = $reporte->getTotalActivoPorFechas($_POST['fecha_inicio'], $_POST['fecha_fin']);
        $ranking = $reporte->getRankingPlatos($_POST['fecha_inicio'], $_POST['fecha_fin']);
        include "views/acciones/verReporteActivos.php";
    }

    public function verAnulados() {
        $reporte = new Reporte();
        $ordenes = $reporte->getOrdenesAnuladasPorFechas($_POST['fecha_inicio'], $_POST['fecha_fin']);
        $total = $reporte->getTotalAnuladoPorFechas($_POST['fecha_inicio'], $_POST['fecha_fin']);
        include "views/acciones/verReporteAnulados.php";
    }
}
