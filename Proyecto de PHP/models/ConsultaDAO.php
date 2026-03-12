<?php
include_once('db/config.php');

class ConsultaDAO {

    public $conexion;

    public function __construct() {
        $this->conexion = Database::conectar();
    }

    // Registra una consulta
    public function registrarConsulta($ciudadId, $tipo) {
        $ip   = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
        $stmt = $this->conexion->prepare(
            "INSERT INTO consultas (ciudad_id, tipo_consulta, ip_cliente)
             VALUES (:ciudad_id, :tipo, :ip)"
        );
        $stmt->bindParam(':ciudad_id', $ciudadId);
        $stmt->bindParam(':tipo',      $tipo);
        $stmt->bindParam(':ip',        $ip);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Devuelve todas las consultas
    public function getAllConsultas() {
        $stmt = $this->conexion->prepare(
            "SELECT c.realizada_en, ci.nombre, ci.pais, c.tipo_consulta, c.ip_cliente
             FROM consultas c
             JOIN ciudades ci ON ci.id = c.ciudad_id
             ORDER BY c.realizada_en DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>