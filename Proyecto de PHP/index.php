<?php
include_once('controllers/BusquedaController.php');
include_once('controllers/ActualController.php');
include_once('controllers/HorasController.php');
include_once('controllers/SemanaController.php');
include_once('controllers/HistorialController.php');
include_once('models/CiudadDAO.php');
include_once('models/WeatherAPI.php');

// Recoge la vista que se quiere mostrar
$vista = $_GET['vista'] ?? 'inicio';

switch ($vista) {

    case 'busqueda':
        $nombreCiudad = $_GET['ciudad'] ?? '';
        $controller   = new BusquedaController();
        $ciudad       = $controller->buscar($nombreCiudad);

        if ($ciudad == null) {
            $error = "No se encontró la ciudad «" . htmlspecialchars($nombreCiudad) . "». Inténtalo de nuevo.";
        }
        include_once('views/inicio.php');
        break;

    case 'actual':
        $ciudadId   = (int)($_GET['id'] ?? 0);
        $controller = new ActualController();
        $tiempo     = $controller->obtenerActual($ciudadId);

        $ciudadDAO  = new CiudadDAO();
        $ciudad     = $ciudadDAO->getCiudadById($ciudadId);

        $api = new WeatherAPI();
        include_once('views/actual.php');
        break;

    case 'horas':
        $ciudadId   = (int)($_GET['id'] ?? 0);
        $controller = new HorasController();
        $horas      = $controller->obtenerHoras($ciudadId);

        $ciudadDAO  = new CiudadDAO();
        $ciudad     = $ciudadDAO->getCiudadById($ciudadId);

        $api = new WeatherAPI();
        include_once('views/horas.php');
        break;

    case 'semana':
        $ciudadId   = (int)($_GET['id'] ?? 0);
        $controller = new SemanaController();
        $dias       = $controller->obtenerSemana($ciudadId);

        $ciudadDAO  = new CiudadDAO();
        $ciudad     = $ciudadDAO->getCiudadById($ciudadId);

        $api = new WeatherAPI();
        include_once('views/semana.php');
        break;

    case 'historial':
        $controller = new HistorialController();
        $consultas  = $controller->obtenerHistorial();
        include_once('views/historial.php');
        break;

    default:
        include_once('views/inicio.php');
        break;
}
?>