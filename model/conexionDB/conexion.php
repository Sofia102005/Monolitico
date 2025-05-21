<?php

namespace app\model\conexionDB;

use mysqli;

class Conexion {
    private $host = "localhost";
    private $dbName = "proyecto_1_db";
    private $username = "root";
    private $password = "";
    private $conn=null;

    public function __construct() {
        $this->conn = new mysqli($this->host,$this->username,$this->password,$this->dbName);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }         
        public function execSQL($sql){
            return $this->conn->query($sql);
        }

        public function close(){
            $this->conn->close();
        }
        public function getConnection() {
            return $this->conn;
        }
}
?>
