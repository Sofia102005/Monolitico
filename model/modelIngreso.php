<?php
require_once 'conexion.php';

class ModeloIngreso {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function getAllIncomes() {
        try {
            $sql = "SELECT i.id AS idIncome, r.month, r.year, i.value 
                    FROM income i
                    INNER JOIN reports r ON i.idReport = r.id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener ingresos: " . $e->getMessage());
        }
    }

    public function addIncome($month, $year, $amount) {
        try {
            if ($amount < 0) {
                throw new Exception("El ingreso no puede ser menor a cero.");
            }
    
            if ($this->existeIngreso($month, $year)) {
                throw new Exception("Ya existe un ingreso para este mes y año.");
            }

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
        } catch (PDOException $e) {
            die("Error al agregar ingreso: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function addOrUpdateIncome($month, $year, $amount) {
        try {
            if ($amount < 0) {
                throw new Exception("El ingreso no puede ser menor a cero.");
            }
    
            if ($this->existeIngreso($month, $year)) {
                throw new Exception("Ya existe un ingreso para este mes y año.");
            }

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
        } catch (PDOException $e) {
            die("Error al agregar o actualizar ingreso: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
 
    public function existeIngreso($month, $year) {
        try {
            $sql = "SELECT * FROM income i
                    INNER JOIN reports r ON i.idReport = r.id
                    WHERE r.month = :month AND r.year = :year";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':month', (int) $month);
            $stmt->bindParam(':year', (int) $year);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Error al verificar ingreso: " . $e->getMessage());
        }
    }

    public function updateIncome($idIncome, $newAmount) {
        try {
            if ($newAmount < 0) {
                throw new Exception("El ingreso no puede ser menor a cero.");
            }

            $sql = "UPDATE income SET value = :amount WHERE id = :idIncome";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $newAmount);
            $stmt->bindParam(':idIncome', $idIncome);
            $stmt->execute();
            return 'actualizado';
        } catch (PDOException $e) {
            die("Error al actualizar ingreso: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function addAmount($idIncome, $amount) {
        try {
            if ($amount < 0) {
                throw new Exception("El ingreso no puede ser menor a cero.");
            }
    
            $sql = "UPDATE income SET value = value + :amount WHERE id = :idIncome";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':idIncome', $idIncome);
            $stmt->execute();
            return 'actualizado';
        } catch (PDOException $e) {
            die("Error al agregar cantidad: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteIncome($idIncome) {
        try {
            $sql = "DELETE FROM income WHERE id = :idIncome";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idIncome', $idIncome);
            $stmt->execute();
            return 'eliminado';
        } catch (PDOException $e) {
            die("Error al eliminar ingreso: " . $e->getMessage());
        }
    }

    // Agregar un nuevo ingreso
    public function addBill($description, $amount, $categoryId, $reportId) {
        try {
            $sql = "INSERT INTO bills (description, value, idCategory, idReport) 
                    VALUES (:description, :amount, :categoryId, :reportId)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':reportId', $reportId);
            $stmt->execute();
            return 'nuevo';
        } catch (PDOException $e) {
            die("Error al agregar gasto: " . $e->getMessage());
        }
    }

    // Actualizar un ingreso
    public function updateBill($idBill, $description, $amount, $categoryId) {
        try {
            $sql = "UPDATE bills SET description = :description, value = :amount, idCategory = :categoryId 
                    WHERE id = :idBill";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':idBill', $idBill);
            $stmt->execute();
            return 'actualizado';
        } catch (PDOException $e) {
            die("Error al actualizar gasto: " . $e->getMessage());
        }
    }

    // Eliminar un ingreso
    public function deleteBill($idBill) {
        try {
            $sql = "DELETE FROM bills WHERE id = :idBill";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idBill', $idBill);
            $stmt->execute();
            return 'eliminado';
        } catch (PDOException $e) {
            die("Error al eliminar gasto: " . $e->getMessage());
        }
    }
}
?>

