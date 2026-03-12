<?php
include_once('models/clases/Ciudad.php');
include_once('models/clases/TiempoActual.php');
include_once('models/clases/TiempoHora.php');
include_once('models/clases/TiempoDia.php');

class WeatherAPI {

    private $apiKey  = '03535ea2eda5a329932b76b5444f540f';
    private $baseUrl = 'https://api.openweathermap.org/data/2.5';
    private $geoUrl  = 'https://api.openweathermap.org/geo/1.0';

    
    public function geocodificar($ciudad) {
        $url   = $this->geoUrl . '/direct?q=' . urlencode($ciudad) . '&limit=1&appid=' . $this->apiKey;
        $datos = $this->llamar($url);
        if (empty($datos)) return null;
        return new Ciudad(null, $datos[0]['name'], $datos[0]['country'], $datos[0]['lat'], $datos[0]['lon']);
    }

    
    public function actual($lat, $lon) {
        $url   = $this->baseUrl . '/weather?lat=' . $lat . '&lon=' . $lon . '&units=metric&lang=es&appid=' . $this->apiKey;
        $datos = $this->llamar($url);
        if (empty($datos)) return null;
        return new TiempoActual(
            $datos['main']['temp'],
            $datos['main']['feels_like'],
            $datos['main']['temp_min'],
            $datos['main']['temp_max'],
            $datos['main']['humidity'],
            $datos['main']['pressure'],
            $datos['wind']['speed'],
            $datos['weather'][0]['description'],
            $datos['weather'][0]['icon']
        );
    }

    

    public function porHoras($lat, $lon) {
        $url   = $this->baseUrl . '/forecast?lat=' . $lat . '&lon=' . $lon . '&cnt=8&units=metric&lang=es&appid=' . $this->apiKey;
        $datos = $this->llamar($url);
        if (empty($datos)) return null;
        $horas = [];
        foreach ($datos['list'] as $item) {
            $horas[] = new TiempoHora(
                date('H:i', $item['dt']),
                $item['main']['temp'],
                $item['main']['humidity'],
                $item['wind']['speed'],
                $item['weather'][0]['description'],
                $item['weather'][0]['icon'],
                $item['pop'] ?? 0
            );
        }
        return $horas;
    }

    


    public function semanal($lat, $lon) {
        $url   = $this->baseUrl . '/forecast?lat=' . $lat . '&lon=' . $lon . '&units=metric&lang=es&appid=' . $this->apiKey;
        $datos = $this->llamar($url);
        if (empty($datos)) return null;

            $dias = [];
            $diasVistos = [];

            foreach ($datos['list'] as $item) {
                $fecha = date('Y-m-d', $item['dt']);
                if (!in_array($fecha, $diasVistos)) {
                    $diasVistos[] = $fecha;
                    $dias[] = new TiempoDia(
                    $fecha,
                    $item['main']['temp_min'],
                    $item['main']['temp_max'],
                    $item['main']['humidity'],
                    $item['wind']['speed'],
                    $item['weather'][0]['description'],
                    $item['weather'][0]['icon'],
                    $item['pop'] ?? 0
            );
        }
    }
    return $dias;
}

    
    private function llamar($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $respuesta = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($respuesta === false || $httpCode !== 200) return null;
        return json_decode($respuesta, true);
    }

    

    
    public function icono($icono) {
        return 'https://openweathermap.org/img/wn/' . $icono . '@2x.png';
    }
}
?>