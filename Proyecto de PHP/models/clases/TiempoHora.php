<?php
class TiempoHora {
    public $hora;
    public $temperatura;
    public $humedad;
    public $viento;
    public $descripcion;
    public $icono;
    public $lluvia;

    public function __construct($hora, $temperatura, $humedad, $viento, $descripcion, $icono, $lluvia) {
        $this->hora         = $hora;
        $this->temperatura  = $temperatura;
        $this->humedad      = $humedad;
        $this->viento       = $viento;
        $this->descripcion  = $descripcion;
        $this->icono        = $icono;
        $this->lluvia       = $lluvia;
    }
}
?>