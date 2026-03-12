<?php
include_once('db/config.php');

class MeteoDAO {

    public $conexion;

    public function __construct() {
        $this->conexion = Database::conectar();
    }

    // Guarda el tiempo actual
    public function guardarActual($ciudadId, $tiempo) {
        $stmt = $this->conexion->prepare(
            "INSERT INTO datos_actuales
             (ciudad_id, temperatura, sensacion_termica, temp_min, temp_max, humedad, presion, velocidad_viento, descripcion, icono)
             VALUES (:ciudad_id, :temperatura, :sensacion, :temp_min, :temp_max, :humedad, :presion, :viento, :descripcion, :icono)"
        );
        $stmt->bindParam(':ciudad_id',   $ciudadId);
        $stmt->bindParam(':temperatura', $tiempo->temperatura);
        $stmt->bindParam(':sensacion',   $tiempo->sensacion);
        $stmt->bindParam(':temp_min',    $tiempo->temp_min);
        $stmt->bindParam(':temp_max',    $tiempo->temp_max);
        $stmt->bindParam(':humedad',     $tiempo->humedad);
        $stmt->bindParam(':presion',     $tiempo->presion);
        $stmt->bindParam(':viento',      $tiempo->viento);
        $stmt->bindParam(':descripcion', $tiempo->descripcion);
        $stmt->bindParam(':icono',       $tiempo->icono);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Guarda la previsión por horas
    public function guardarHoras($ciudadId, $horas) {
        $this->conexion->prepare(
            "DELETE FROM datos_horas WHERE ciudad_id = :ciudad_id AND DATE(obtenido_en) = CURDATE()"
        )->execute([':ciudad_id' => $ciudadId]);

        $stmt = $this->conexion->prepare(
            "INSERT INTO datos_horas
             (ciudad_id, dt, temperatura, humedad, velocidad_viento, descripcion, icono, probabilidad_lluvia)
             VALUES (:ciudad_id, :dt, :temperatura, :humedad, :viento, :descripcion, :icono, :lluvia)"
        );
        foreach ($horas as $hora) {
            $stmt->bindParam(':ciudad_id',   $ciudadId);
            $stmt->bindParam(':dt',          $hora->hora);
            $stmt->bindParam(':temperatura', $hora->temperatura);
            $stmt->bindParam(':humedad',     $hora->humedad);
            $stmt->bindParam(':viento',      $hora->viento);
            $stmt->bindParam(':descripcion', $hora->descripcion);
            $stmt->bindParam(':icono',       $hora->icono);
            $stmt->bindParam(':lluvia',      $hora->lluvia);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    // Guarda la previsión semanal
    public function guardarSemana($ciudadId, $dias) {
        $this->conexion->prepare(
            "DELETE FROM datos_semana WHERE ciudad_id = :ciudad_id AND obtenido_en >= CURDATE()"
        )->execute([':ciudad_id' => $ciudadId]);

        $stmt = $this->conexion->prepare(
            "INSERT INTO datos_semana
             (ciudad_id, fecha, temp_min, temp_max, humedad, velocidad_viento, descripcion, icono, probabilidad_lluvia)
             VALUES (:ciudad_id, :fecha, :temp_min, :temp_max, :humedad, :viento, :descripcion, :icono, :lluvia)"
        );
        foreach ($dias as $dia) {
            $stmt->bindParam(':ciudad_id', $ciudadId);
            $stmt->bindParam(':fecha',     $dia->fecha);
            $stmt->bindParam(':temp_min',  $dia->temp_min);
            $stmt->bindParam(':temp_max',  $dia->temp_max);
            $stmt->bindParam(':humedad',   $dia->humedad);
            $stmt->bindParam(':viento',    $dia->viento);
            $stmt->bindParam(':descripcion', $dia->descripcion);
            $stmt->bindParam(':icono',     $dia->icono);
            $stmt->bindParam(':lluvia',    $dia->lluvia);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
?>