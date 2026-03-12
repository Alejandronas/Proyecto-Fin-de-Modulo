<?php
include_once('models/WeatherAPI.php');
include_once('models/CiudadDAO.php');
include_once('models/MeteoDAO.php');
include_once('models/ConsultaDAO.php');

class SemanaController {

    public function obtenerSemana($ciudadId) {
        
        $ciudadDAO = new CiudadDAO();
        $ciudad    = $ciudadDAO->getCiudadById($ciudadId);
        if ($ciudad == null) return null;

        
        $api  = new WeatherAPI();
        $dias = $api->semanal($ciudad->lat, $ciudad->lon);
        if ($dias == null) return null;

        
        $meteoDAO = new MeteoDAO();
        $meteoDAO->guardarSemana($ciudadId, $dias);

        
        $consultaDAO = new ConsultaDAO();
        $consultaDAO->registrarConsulta($ciudadId, 'semana');

        return $dias;
    }
}
?>