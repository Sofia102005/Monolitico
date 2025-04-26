<?php
require_once 'conexion.php';

class Modelo {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    // Obtener todos los ingresos
    public function getAllIncomes() {
        try {
            $sql = "SELECT r.month, r.year, i.value 
                    FROM income i
                    INNER JOIN reports r ON i.idReport = r.id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener ingresos: " . $e->getMessage());
        }
    }

    // Agregar o actualizar un ingreso
    public function addOrUpdateIncome($month, $year, $amount) {
        try {
            if ($amount < 0) {
                throw new Exception("El ingreso no puede ser menor a cero.");
            }

            // Verificar si ya existe un reporte con ese mes y año
            $sql = "SELECT id FROM reports WHERE month = :month AND year = :year";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->execute();
            $report = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($report) {
                // Ya existe, actualizamos solo el valor del ingreso
                $idReport = $report['id'];
                $sql = "UPDATE income SET value = :amount WHERE idReport = :idReport";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':idReport', $idReport);
                $stmt->execute();
                return 'actualizado';
            } else {
                // Crear nuevo reporte e ingreso
                $sql = "INSERT INTO reports (month, year) VALUES (:month, :year)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':month', $month);
                $stmt->bindParam(':year', $year);
                $stmt->execute();
                $idReport = $this->conexion->lastInsertId();

                $sql = "INSERT INTO income (value, idReport) VALUES (:amount, :idReport)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':idReport', $idReport);
                $stmt->execute();
                return 'nuevo';
            }
        } catch (PDOException $e) {
            die("Error al agregar o actualizar ingreso: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>
