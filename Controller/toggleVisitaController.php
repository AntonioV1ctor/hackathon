<?php
require_once '../init.php';
require_once '../Model/usuarioModel.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$restauranteId = $input['restaurante_id'] ?? null;
$acao = $input['acao'] ?? null; // 'adicionar' ou 'remover'

if (!$restauranteId || !$acao) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$usuarioModel = new UsuarioModel();
$usuarioId = $_SESSION['id'];
$resultado = false;

if ($acao === 'adicionar') {
    $resultado = $usuarioModel->adicionarVisita($usuarioId, $restauranteId);
} elseif ($acao === 'remover') {
    $resultado = $usuarioModel->removerVisita($usuarioId, $restauranteId);
}

if ($resultado) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status']);
}
