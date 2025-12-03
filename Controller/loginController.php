<?php
session_start();
require_once __DIR__ . "/../Model/LoginModel.php";

try {
    
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método inválido para esta requisição");
    }

    // Rate Limiting
    if (isset($_SESSION['loginBloqueado']) && time() < $_SESSION['loginBloqueado']) {
        $restante = $_SESSION['loginBloqueado'] - time();
        throw new Exception("Muitas tentativas de login. Tente novamente em alguns segundos.");
    }

    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        throw new Exception("Preencha todos os campos");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Informe um email válido");
    }

    $loginModel = new LoginModel();
    $usuarioLogin = $loginModel->Login($email, $senha);

    if (!$usuarioLogin) {
        
        $_SESSION['loginTentativas'] = ($_SESSION['loginTentativas'] ?? 0) + 1;

        if ($_SESSION['loginTentativas'] >= 5) {
            $_SESSION['loginBloqueado'] = time() + 120; // 2 minutos
            $_SESSION['loginTentativas'] = 0;
            throw new Exception("Muitas tentativas de login. Aguarde 2 minutos.");
        }

        throw new Exception("Email ou senha incorretos.");
    } else {
        
        $_SESSION['id'] = $usuarioLogin->id;
        $_SESSION['tipo'] = $usuarioLogin->tipo; // Adaptado de tipo_perfil para tipo
        $_SESSION['email'] = $usuarioLogin->email;
        $_SESSION['usuario'] = $usuarioLogin->email; // Mantendo compatibilidade

        $_SESSION['loginTentativas'] = 0;
        unset($_SESSION['loginBloqueado']);

        header('Location: ../index.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    header('Location: ../View/pages/login.php');
    exit();
}
