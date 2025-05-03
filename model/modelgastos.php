<?php
require_once 'conexion.php';

class ModeloGasto {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    /**
     * Agrega un gasto, creando el reporte si no existe.
     */
    public function addBill($amount, $categoryId, $month, $year) {
        try {
            // Verificar si ya existe un reporte
            $sql = "SELECT id FROM reports WHERE month = :month AND year = :year";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $idReport = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
            } else {
                $sql = "INSERT INTO reports (month, year) VALUES (:month, :year)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':month', $month);
                $stmt->bindParam(':year', $year);
                $stmt->execute();
                $idReport = $this->conexion->lastInsertId();
            }

            // Insertar gasto
            $sql = "INSERT INTO bills (value, idCategory, idReport) 
                    VALUES (:amount, :categoryId, :idReport)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':idReport', $idReport);
            $stmt->execute();

            return 'nuevo';
        } catch (PDOException $e) {
            die("Error al agregar gasto: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un gasto existente.
     */
    public function updateBill($id, $amount, $categoryId) {
        try {
            $sql = "UPDATE bills 
                    SET value = :amount, idCategory = :categoryId 
                    WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return 'actualizado';
        } catch (PDOException $e) {
            die("Error al actualizar gasto: " . $e->getMessage());
        }
    }

    /**
     * Elimina un gasto por su ID.
     */
    public function deleteBill($id) {
        try {
            $sql = "DELETE FROM bills WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return 'eliminado';
        } catch (PDOException $e) {
            die("Error al eliminar gasto: " . $e->getMessage());
        }
    }

    /**
     * Obtiene todos los gastos con sus categorías y fechas.
     */
    public function getAllBills() {
        try {
            $sql = "SELECT 
                        b.id AS id,
                        r.month,
                        r.year,
                        b.value,
                        c.name AS category
                    FROM bills b
                    INNER JOIN categories c ON b.idCategory = c.id
                    INNER JOIN reports r ON b.idReport = r.id
                    ORDER BY r.year DESC, r.month DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener gastos: " . $e->getMessage());
        }
    }
}
