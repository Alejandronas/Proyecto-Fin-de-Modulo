<?php
include_once('models/WeatherAPI.php');
include_once('models/CiudadDAO.php');
include_once('models/MeteoDAO.php');
include_once('models/ConsultaDAO.php');

class ActualController {

    public function obtenerActual($ciudadId) {
        
        $ciudadDAO = new CiudadDAO();
        $ciudad    = $ciudadDAO->getCiudadById($ciudadId);
        if ($ciudad == null) return null;
        
        $api    = new WeatherAPI();
        $tiempo = $api->actual($ciudad->lat, $ciudad->lon);
        if ($tiempo == null) return null;
        
        $meteoDAO = new MeteoDAO();
        $meteoDAO->guardarActual($ciudadId, $tiempo);


        
        $consultaDAO = new ConsultaDAO();
        $consultaDAO->registrarConsulta($ciudadId, 'actual');

        return $tiempo;
    }
}
?>