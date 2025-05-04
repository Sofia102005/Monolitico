<?php
require_once 'conexion.php';

class ModeloGasto {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

   
    public function addBill($amount, $categoryId, $month, $year) {
        try {
            // ...
            // Insertar gasto
            $sql = "INSERT INTO bills (value, idCategory, idReport) 
                    VALUES (:amount, :categoryId, :idReport)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':idReport', $idReport);
            $stmt->execute();
            
            // Actualizar sesión con el mes y año del gasto recién insertado
            $_SESSION['month'] = $month;
            $_SESSION['year'] = $year;
            
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

    public function getCategorias() {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener categorías: " . $e->getMessage());
        }
    }

    public function getBillsByMonth($month, $year) {
        try {
            $sql = "SELECT * FROM bills WHERE idReport IN (SELECT id FROM reports WHERE month = :month AND year = :year)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener gastos: " . $e->getMessage());
        }
    }

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
