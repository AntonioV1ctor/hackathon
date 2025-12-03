<?php

require_once __DIR__ . '/../Config/database.php';

class UsuarioModel
{
    private $conn;
    
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function cadastrarUsuario($nome, $email, $senha)
    {
        try {
            if ($this->findUsuarioByEmail($email)) {
                return false;
            }

            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
            
            $query = "INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (:nome, :email, :senha_hash, :tipo)";
            $stmt = $this->conn->prepare($query);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha_hash' => $senhaHash,
                ':tipo' => 'usuario',
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function findUsuarioByEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}