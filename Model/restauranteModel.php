<?php

require_once __DIR__ . '/../Config/database.php';

class RestauranteModel
{
    protected $conn;
    protected $tabela = "restaurantes";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    /**
     * Cadastra um novo restaurante
     * @param array $dados Array associativo com os dados do restaurante
     * @return bool
     */
    public function cadastrarRestaurante($dados)
    {
        try {
            $sql = "INSERT INTO {$this->tabela} 
                    (nome, cidade, categoria, descricao, endereco, lat, log, horario_funcionamento, faixa_preco, caminho_imagem) 
                    VALUES 
                    (:nome, :cidade, :categoria, :descricao, :endereco, :lat, :log, :horario_funcionamento, :faixa_preco, :caminho_imagem)";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':cidade', $dados['cidade']);
            $stmt->bindValue(':categoria', $dados['categoria']);
            $stmt->bindValue(':descricao', $dados['descricao']);
            $stmt->bindValue(':endereco', $dados['endereco']);
            $stmt->bindValue(':lat', $dados['lat'] ?? null);
            $stmt->bindValue(':log', $dados['log'] ?? null);
            $stmt->bindValue(':horario_funcionamento', $dados['horario_funcionamento']);
            $stmt->bindValue(':faixa_preco', $dados['faixa_preco']);
            $stmt->bindValue(':caminho_imagem', $dados['caminho_imagem']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar restaurante: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lista todos os restaurantes
     * @return array
     */
    public function listarRestaurantes()
    {
        try {
            $sql = "SELECT * FROM {$this->tabela} ORDER BY nome ASC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar restaurantes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca um restaurante pelo ID
     * @param int $id
     * @return array|false
     */
    public function buscarRestaurantePorId($id)
    {
        try {
            $sql = "SELECT * FROM {$this->tabela} WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar restaurante por ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza os dados de um restaurante
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizarRestaurante($id, $dados)
    {
        try {
            $campos = [];
            foreach ($dados as $chave => $valor) {
                $campos[] = "$chave = :$chave";
            }
            $camposStr = implode(', ', $campos);

            $sql = "UPDATE {$this->tabela} SET $camposStr WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            foreach ($dados as $chave => $valor) {
                $stmt->bindValue(":$chave", $valor);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar restaurante: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Exclui um restaurante pelo ID
     * @param int $id
     * @return bool
     */
    public function excluirRestaurante($id)
    {
        try {
            $sql = "DELETE FROM {$this->tabela} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao excluir restaurante: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca restaurantes com filtros
     * @param array $filtros (q, cidade, culinaria, preco, rating)
     * @return array
     */
    public function buscarRestaurantesPorFiltro($filtros = [])
    {
        try {
            $sql = "SELECT r.*, COALESCE(AVG(a.nota), 0) as media_avaliacao 
                    FROM {$this->tabela} r 
                    LEFT JOIN avaliacoes a ON r.id = a.referencia_id 
                    WHERE 1=1";
            
            $params = [];

            if (!empty($filtros['q'])) {
                $sql .= " AND (r.nome LIKE :q OR r.descricao LIKE :q)";
                $params[':q'] = '%' . $filtros['q'] . '%';
            }

            if (!empty($filtros['cidade'])) {
                $sql .= " AND r.cidade = :cidade";
                $params[':cidade'] = $filtros['cidade'];
            }

            if (!empty($filtros['culinaria'])) {
                $sql .= " AND r.categoria = :culinaria";
                $params[':culinaria'] = $filtros['culinaria'];
            }

            if (!empty($filtros['preco'])) {
                $sql .= " AND r.faixa_preco = :preco";
                $params[':preco'] = $filtros['preco'];
            }

            $sql .= " GROUP BY r.id";

            if (!empty($filtros['rating'])) {
                $sql .= " HAVING media_avaliacao >= :rating";
                $params[':rating'] = $filtros['rating'];
            }

            $sql .= " ORDER BY r.nome ASC";

            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erro ao buscar restaurantes por filtro: " . $e->getMessage());
            return [];
        }
    }
}
