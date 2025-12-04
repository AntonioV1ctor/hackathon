<?php

require_once __DIR__ . '/../Config/database.php';

class LoginModel
{
    protected $conn;
    protected $tabela = "usuarios";
    
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function login($email, $senha)
    {
        try {
            $sql = "SELECT id, tipo, email, senha_hash FROM {$this->tabela} WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                unset($usuario['senha_hash']);
                return (object) $usuario;
            }

            return false;
        } catch (PDOException $e) {
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }

    public function verificarEmailExistente($email)
    {
        try {
            $email = trim($email);
            $sql = "SELECT 1 FROM {$this->tabela} WHERE LOWER(email) = LOWER(?) LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetchColumn() !== false;
        } catch (PDOException $e) {
            error_log("Erro ao verificar email existente: " . $e->getMessage());
            return false;
        }
    }
}