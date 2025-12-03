<?php
session_start();
require_once __DIR__ . "/../Model/RestauranteModel.php";

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método inválido. Utilize POST.");
    }

    $method = $_POST['_method'] ?? 'POST';
    $restauranteModel = new RestauranteModel();

    // =================================================================================
    // CREATE (POST)
    // =================================================================================
    if ($method === 'POST') {
        $nome = $_POST['nome'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $endereco = $_POST['endereco'] ?? '';
        $horario = $_POST['horario_funcionamento'] ?? '';
        $preco = $_POST['faixa_preco'] ?? '';
        
        // Upload de Imagem
        $caminhoImagem = '';
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../View/assets/img/restaurantes/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid() . "." . $extensao;
            $destino = $uploadDir . $novoNome;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $caminhoImagem = '/hackathon/View/assets/img/restaurantes/' . $novoNome;
            } else {
                throw new Exception("Erro ao fazer upload da imagem.");
            }
        }

        if (empty($nome) || empty($cidade) || empty($categoria)) {
            throw new Exception("Preencha os campos obrigatórios (Nome, Cidade, Categoria).");
        }

        $dados = [
            'nome' => $nome,
            'cidade' => $cidade,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'endereco' => $endereco,
            'horario_funcionamento' => $horario,
            'faixa_preco' => $preco,
            'caminho_imagem' => $caminhoImagem
        ];

        if ($restauranteModel->cadastrarRestaurante($dados)) {
            $_SESSION['type'] = 'sucesso';
            $_SESSION['message'] = 'Restaurante cadastrado com sucesso!';
            header('Location: /hackathon/View/pages/Administracao.php');
            exit();
        } else {
            throw new Exception("Erro ao cadastrar restaurante no banco de dados.");
        }
    }

    // =================================================================================
    // UPDATE (PUT)
    // =================================================================================
    elseif ($method === 'PUT') {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            throw new Exception("ID do restaurante não informado para atualização.");
        }

        $dadosAtuais = $restauranteModel->buscarRestaurantePorId($id);
        if (!$dadosAtuais) {
            throw new Exception("Restaurante não encontrado.");
        }

        $nome = $_POST['nome'] ?? $dadosAtuais['nome'];
        $cidade = $_POST['cidade'] ?? $dadosAtuais['cidade'];
        $categoria = $_POST['categoria'] ?? $dadosAtuais['categoria'];
        $descricao = $_POST['descricao'] ?? $dadosAtuais['descricao'];
        $endereco = $_POST['endereco'] ?? $dadosAtuais['endereco'];
        $horario = $_POST['horario_funcionamento'] ?? $dadosAtuais['horario_funcionamento'];
        $preco = $_POST['faixa_preco'] ?? $dadosAtuais['faixa_preco'];
        
        // Upload de nova imagem (opcional)
        $caminhoImagem = $dadosAtuais['caminho_imagem'];
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../View/assets/img/restaurantes/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid() . "." . $extensao;
            $destino = $uploadDir . $novoNome;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $caminhoImagem = '/hackathon/View/assets/img/restaurantes/' . $novoNome;
            }
        }

        $dados = [
            'nome' => $nome,
            'cidade' => $cidade,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'endereco' => $endereco,
            'horario_funcionamento' => $horario,
            'faixa_preco' => $preco,
            'caminho_imagem' => $caminhoImagem
        ];

        if ($restauranteModel->atualizarRestaurante($id, $dados)) {
            $_SESSION['type'] = 'sucesso';
            $_SESSION['message'] = 'Restaurante atualizado com sucesso!';
            header('Location: /hackathon/View/pages/Administracao.php');
            exit();
        } else {
            throw new Exception("Erro ao atualizar restaurante.");
        }
    }

} catch (Exception $e) {
    $_SESSION['type'] = 'erro';
    $_SESSION['message'] = $e->getMessage();
    // Redireciona de volta para a página anterior ou para a administração
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: /hackathon/View/pages/Administracao.php');
    }
    exit();
}
