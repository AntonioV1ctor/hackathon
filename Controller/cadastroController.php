<?php
require_once __DIR__ . '/../Model/usuarioModel.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar)) {
        $_SESSION['type'] = 'erro';
        $_SESSION['message'] = 'Preencha todos os campos!';
        header("Location: /hackathon/View/pages/cadastro.php");
        exit;
    }

    if ($senha !== $confirmar) {
        $_SESSION['type'] = 'erro';
        $_SESSION['message'] = 'As senhas não coincidem!';
        header("Location: /hackathon/View/pages/cadastro.php");
        exit;
    }

    $usuarioModel = new UsuarioModel();

    if ($usuarioModel->cadastrarUsuario($nome, $email, $senha)) {
        $_SESSION['type'] = 'sucesso';
        $_SESSION['message'] = 'Conta criada com sucesso! Faça login.';
        header("Location: /hackathon/View/pages/login.php");
        exit;
    } else {
        $_SESSION['type'] = 'erro';
        $_SESSION['message'] = 'Erro ao criar conta. Verifique se o e-mail já está cadastrado.';
        header("Location: /hackathon/View/pages/cadastro.php");
        exit;
    }
}
