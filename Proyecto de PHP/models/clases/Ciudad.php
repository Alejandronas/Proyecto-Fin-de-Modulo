<?php
class Ciudad {
    public $id;
    public $nombre;
    public $pais;
    public $lat;
    public $lon;

    public function __construct($id, $nombre, $pais, $lat, $lon) {
        $this->id     = $id;
        $this->nombre = $nombre;
        $this->pais   = $pais;
        $this->lat    = $lat;
        $this->lon    = $lon;
    }
}



?>