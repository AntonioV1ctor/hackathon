<?php
session_start();

// Recebe o JSON do fetch
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$senha = $data['senha'] ?? '';

// MOCK DE LOGIN (Posteriormente conectar com banco)
if ($email === 'admin@ms.com' && $senha === '1234') {
    $_SESSION['usuario'] = 'Admin';
    $_SESSION['email'] = $email;
    $_SESSION['tipo'] = 'admin'; // Para testar a parte de admin na navbar

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos.']);
}
