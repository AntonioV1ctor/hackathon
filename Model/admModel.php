<?php

require_once __DIR__ . '/../Config/database.php';

class AdmModel
{
    private $conn;
    
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }
}