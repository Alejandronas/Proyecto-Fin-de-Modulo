<?php
class TiempoDia {
    public $fecha;
    public $temp_min;
    public $temp_max;
    public $humedad;
    public $viento;
    public $descripcion;
    public $icono;
    public $lluvia;

    public function __construct($fecha, $temp_min, $temp_max, $humedad, $viento, $descripcion, $icono, $lluvia) {
        $this->fecha        = $fecha;
        $this->temp_min     = $temp_min;
        $this->temp_max     = $temp_max;
        $this->humedad      = $humedad;
        $this->viento       = $viento;
        $this->descripcion  = $descripcion;
        $this->icono        = $icono;
        $this->lluvia       = $lluvia;
    }
}
?>