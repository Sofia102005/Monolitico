<?php

namespace app\model\entities;

require_once __DIR__ . '/../conexionDB/Conexion.php';

use mysqli;
use mysqli_sql_exception;
use app\model\conexionDB\Conexion;


class ModeloGasto
{
    private mysqli $db;
    private array $data = [];

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->getConnection();
    }

    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function getAllBills(): array
    {
        $result = $this->db->query("SELECT * FROM gastos");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function save(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO gastos (value, month, year, category_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param(
            "diii",
            $this->data['value'],
            $this->data['month'],
            $this->data['year'],
            $this->data['categoryId']
        );
        return $stmt->execute();
    }

    public function update(): bool
    {
        $stmt = $this->db->prepare("UPDATE gastos SET value = ?, month = ?, year = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param(
            "diiii",
            $this->data['value'],
            $this->data['month'],
            $this->data['year'],
            $this->data['categoryId'],
            $this->data['id']
        );
        return $stmt->execute();
    }

    public function delete(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM gastos WHERE id = ?");
        $stmt->bind_param("i", $this->data['id']);
        return $stmt->execute();
    }

    public function getBillsByMonth(int $month, int $year): array
    {
        $stmt = $this->db->prepare("SELECT * FROM gastos WHERE month = ? AND year = ?");
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
