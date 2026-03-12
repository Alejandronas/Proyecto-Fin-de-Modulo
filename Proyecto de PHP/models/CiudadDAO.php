<?php
include_once('db/config.php');
include_once('models/clases/Ciudad.php');

class CiudadDAO {

    public $conexion;

    public function __construct() {
        $this->conexion = Database::conectar();
    }

    // Guarda una ciudad y devuelve su id
    public function guardarCiudad($ciudad) {
        $stmt = $this->conexion->prepare(
            "INSERT INTO ciudades (nombre, pais, lat, lon)
             VALUES (:nombre, :pais, :lat, :lon)
             ON DUPLICATE KEY UPDATE lat = :lat, lon = :lon"
        );
        $stmt->bindParam(':nombre', $ciudad->nombre);
        $stmt->bindParam(':pais',   $ciudad->pais);
        $stmt->bindParam(':lat',    $ciudad->lat);
        $stmt->bindParam(':lon',    $ciudad->lon);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $stmt2 = $this->conexion->prepare(
            "SELECT id FROM ciudades WHERE nombre = :nombre AND pais = :pais"
        );
        $stmt2->bindParam(':nombre', $ciudad->nombre);
        $stmt2->bindParam(':pais',   $ciudad->pais);
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }

    // Devuelve un objeto Ciudad por su id
    public function getCiudadById($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM ciudades WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;
        return new Ciudad($fila['id'], $fila['nombre'], $fila['pais'], $fila['lat'], $fila['lon']);
    }

    // Devuelve todas las ciudades como array de objetos Ciudad
    public function getAllCiudades() {
        $stmt = $this->conexion->prepare("SELECT * FROM ciudades ORDER BY nombre ASC");
        $stmt->execute();
        $ciudades = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $fila) {
            $ciudades[] = new Ciudad($fila['id'], $fila['nombre'], $fila['pais'], $fila['lat'], $fila['lon']);
        }
        return $ciudades;
    }
}
?>