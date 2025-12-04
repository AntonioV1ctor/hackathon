<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Model/usuarioModel.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';
        $perguntaSeguranca = $_POST['pergunta_seguranca'] ?? '';
        $respostaSeguranca = $_POST['resposta_seguranca'] ?? '';

        if (empty($nome) || empty($email) || empty($senha) || empty($confirmar) || empty($perguntaSeguranca) || empty($respostaSeguranca)) {
            throw new Exception('Preencha todos os campos!');
        }

        if ($senha !== $confirmar) {
            throw new Exception('As senhas não coincidem!');
        }

        $usuarioModel = new UsuarioModel();

        if ($usuarioModel->cadastrarUsuario($nome, $email, $senha, $perguntaSeguranca, $respostaSeguranca)) {
            $_SESSION['type'] = 'sucesso';
            $_SESSION['message'] = 'Conta criada com sucesso! Faça login.';
            header("Location: /hackathon/View/pages/login.php");
            exit;
        } else {
            throw new Exception('Erro ao criar conta. Verifique se o e-mail já está cadastrado.');
        }
    } catch (Exception $e) {
        $_SESSION['type'] = 'erro';
        $_SESSION['message'] = $e->getMessage();
        header("Location: /hackathon/View/pages/cadastro.php");
        exit;
    }
}
