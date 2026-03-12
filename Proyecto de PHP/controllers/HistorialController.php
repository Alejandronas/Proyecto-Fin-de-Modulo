<?php
include_once('models/ConsultaDAO.php');

class HistorialController {

    public function obtenerHistorial() {
        $consultaDAO = new ConsultaDAO();
        return $consultaDAO->getAllConsultas();
    }
}
?>