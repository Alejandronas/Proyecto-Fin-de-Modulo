<?php
class TiempoActual {
    public $temperatura;
    public $sensacion;
    public $temp_min;
    public $temp_max;
    public $humedad;
    public $presion;
    public $viento;
    public $descripcion;
    public $icono;

    public function __construct($temperatura, $sensacion, $temp_min, $temp_max, $humedad, $presion, $viento, $descripcion, $icono) {
        $this->temperatura  = $temperatura;
        $this->sensacion    = $sensacion;
        $this->temp_min     = $temp_min;
        $this->temp_max     = $temp_max;
        $this->humedad      = $humedad;
        $this->presion      = $presion;
        $this->viento       = $viento;
        $this->descripcion  = $descripcion;
        $this->icono        = $icono;
    }
}
?>