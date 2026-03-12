<?php
include_once('models/WeatherAPI.php');
include_once('models/CiudadDAO.php');
include_once('models/MeteoDAO.php');
include_once('models/ConsultaDAO.php');

class HorasController {

    public function obtenerHoras($ciudadId) {
       
        $ciudadDAO = new CiudadDAO();
        $ciudad    = $ciudadDAO->getCiudadById($ciudadId);
        if ($ciudad == null) return null;

        
        $api   = new WeatherAPI();
        $horas = $api->porHoras($ciudad->lat, $ciudad->lon);
        if ($horas == null) return null;

        
        $meteoDAO = new MeteoDAO();
        $meteoDAO->guardarHoras($ciudadId, $horas);

        
        $consultaDAO = new ConsultaDAO();
        $consultaDAO->registrarConsulta($ciudadId, 'horas');

        return $horas;
    }
}
?>