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
            return [];
        }
    }

    public function addIncome($month, $year, $amount) {
        try {
            if ($amount < 0) return "error";
            if ($this->existeIngreso($month, $year)) return "error";

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
            return "error";
        }
    }

    public function updateIncome($idIncome, $newAmount) {
        try {
            if ($newAmount < 0) return "error";

            $sql = "UPDATE income SET value = :amount WHERE id = :idIncome";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $newAmount);
            $stmt->bindParam(':idIncome', $idIncome);
            $stmt->execute();

            return 'actualizado';
        } catch (PDOException $e) {
            return "error";
        }
    }

    public function addAmount($idIncome, $amount) {
        try {
            if ($amount < 0) return "error";

            $sql = "UPDATE income SET value = value + :amount WHERE id = :idIncome";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':idIncome', $idIncome);
            $stmt->execute();

            return 'actualizado';
        } catch (PDOException $e) {
            return "error";
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
            return "error";
        }
    }

    private function existeIngreso($month, $year) {
        $sql = "SELECT i.id FROM income i
                INNER JOIN reports r ON i.idReport = r.id
                WHERE r.month = :month AND r.year = :year";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
