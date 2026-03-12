<?php
include_once('models/WeatherAPI.php');
include_once('models/CiudadDAO.php');

class BusquedaController {

    public function buscar($nombreCiudad) {
        
        $api    = new WeatherAPI();
        $ciudad = $api->geocodificar($nombreCiudad);

        


        if ($ciudad == null) return null;

       
        $ciudadDAO  = new CiudadDAO();
        $ciudad->id = $ciudadDAO->guardarCiudad($ciudad);

        return $ciudad;
    }
}
?>