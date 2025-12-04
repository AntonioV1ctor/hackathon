<?php
require_once '../init.php';
require_once '../Model/usuarioModel.php';
require_once '../Services/sessaoService.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
    exit;
}

if (!isset($_FILES['foto_perfil']) || $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Erro no upload do arquivo']);
    exit;
}

$file = $_FILES['foto_perfil'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxSize = 5 * 1024 * 1024; // 5MB

if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido. Apenas JPG, PNG, GIF e WebP.']);
    exit;
}

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'Arquivo muito grande. Máximo 5MB.']);
    exit;
}

$uploadDir = __DIR__ . '/../assets/uploads/perfis/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileName = 'perfil_' . $_SESSION['id'] . '_' . time() . '.' . $extension;
$targetPath = $uploadDir . $fileName;
$publicPath = '/hackathon/assets/uploads/perfis/' . $fileName;

if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    $usuarioModel = new UsuarioModel();
    if ($usuarioModel->atualizarFotoPerfil($_SESSION['id'], $publicPath)) {
        // Update session
        $_SESSION['foto_perfil'] = $publicPath;

        echo json_encode(['success' => true, 'url' => $publicPath]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar banco de dados']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar arquivo']);
}
