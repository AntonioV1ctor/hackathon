<?php
require_once '../../init.php';
AutenticacaoService::validarAcessoAdmin();

// Verifica se foi enviado (Simulação de backend)
$sucesso = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui entraria o INSERT no banco de dados
    $sucesso = true;
}
require_once '../../Model/RestauranteModel.php';
require_once '../../Services/categoriaService.php';

$restauranteModel = new RestauranteModel();
$restaurante = null;
$isEdit = false;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $restaurante = $restauranteModel->buscarRestaurantePorId($id);
    if ($restaurante) {
        $isEdit = true;
    }
}

require_once '../components/head.php';
?>

<body class="min-h-screen bg-slate-100 font-sans">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-4xl mx-auto px-4 py-10">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#004e64]"><?= $isEdit ? 'Editar Restaurante' : 'Novo Restaurante' ?>
                </h1>
                <p class="text-slate-500">Preencha as informações para
                    <?= $isEdit ? 'atualizar o' : 'cadastrar um novo' ?> estabelecimento.
                </p>
            </div>
            <a href="/hackathon/View/pages/administracao.php" class="text-sm text-slate-500 hover:text-[#004e64]">
                cancelar
            </a>
        </div>

        <form method="POST" action="../../Controller/restauranteController.php" enctype="multipart/form-data"
            class="space-y-6">

            <input type="hidden" name="_method" value="<?= $isEdit ? 'PUT' : 'POST' ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $restaurante['id'] ?>">
            <?php endif; ?>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold text-[#004e64] mb-4 border-b pb-2">Dados Gerais</h2>

                <div class="grid md:grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nome do Restaurante</label>
                        <input type="text" name="nome" required placeholder="Ex: Casa do João"
                            value="<?= $isEdit ? $restaurante['nome'] : '' ?>"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Cidade</label>
                        <select name="cidade"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                            <?php
                            $jsonPath = __DIR__ . '/../../data/cidades.json';
                            if (file_exists($jsonPath)) {
                                $jsonContent = file_get_contents($jsonPath);
                                $data = json_decode($jsonContent, true);
                                if (isset($data['estados'][0]['cidades'])) {
                                    foreach ($data['estados'][0]['cidades'] as $cidade) {
                                        $selected = ($isEdit && $restaurante['cidade'] == $cidade) ? 'selected' : '';
                                        echo "<option value=\"$cidade\" $selected>$cidade</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Categoria (Culinária)</label>

                        <select name="categoria" required
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">

                            <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Selecione uma categoria...
                            </option>

                            <?php 
                            $categorias = CategoriaService::listarCategorias();
                            foreach ($categorias as $cat): 
                            ?>
                                <option value="<?= $cat ?>" <?= ($isEdit && $restaurante['categoria'] == $cat) ? 'selected' : '' ?>>
                                    <?= $cat ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Faixa de Preço</label>
                        <select name="faixa_preco"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                            <option value="1" <?= ($isEdit && $restaurante['faixa_preco'] == 1) ? 'selected' : '' ?>>Barato
                                ($)</option>
                            <option value="2" <?= ($isEdit && $restaurante['faixa_preco'] == 2) ? 'selected' : '' ?>>
                                Moderado ($$)</option>
                            <option value="3" <?= ($isEdit && $restaurante['faixa_preco'] == 3) ? 'selected' : '' ?>>Caro
                                ($$$)</option>
                            <option value="4" <?= ($isEdit && $restaurante['faixa_preco'] == 4) ? 'selected' : '' ?>>
                                Sofisticado ($$$$)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Horário de Funcionamento</label>
                        <input type="text" name="horario_funcionamento" placeholder="Ex: 11:00 às 23:00"
                            value="<?= $isEdit ? $restaurante['horario_funcionamento'] : '' ?>"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Descrição</label>
                        <textarea name="descricao" rows="3"
                            placeholder="Conte um pouco sobre a história e o ambiente..."
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64] resize-none"><?= $isEdit ? $restaurante['descricao'] : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold text-[#004e64] mb-4 border-b pb-2">Localização</h2>

                <div class="grid md:grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Endereço Completo</label>
                        <input type="text" name="endereco" placeholder="Rua, Número, Bairro"
                            value="<?= $isEdit ? $restaurante['endereco'] : '' ?>"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Latitude</label>
                        <input type="text" name="lat" placeholder="-21.12345"
                            value="<?= $isEdit ? $restaurante['lat'] : '' ?>"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Longitude</label>
                        <input type="text" name="log" placeholder="-56.12345"
                            value="<?= $isEdit ? $restaurante['log'] : '' ?>"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>
                    <div class="col-span-2 text-xs text-slate-500">
                        * Dica: Abra o Google Maps, clique com botão direito no local e copie as coordenadas.
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold text-[#004e64] mb-4 border-b pb-2">Imagens</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto de Capa (Principal)</label>
                        <?php if ($isEdit && !empty($restaurante['caminho_imagem'])): ?>
                            <div class="mb-2">
                                <img src="<?= $restaurante['caminho_imagem'] ?>" alt="Imagem atual"
                                    class="h-32 w-auto rounded-lg object-cover border border-slate-200">
                                <p class="text-xs text-slate-500 mt-1">Imagem atual</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="imagem" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#004e64] file:text-white hover:file:bg-[#003947] transition">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 pb-12">
                <button type="submit"
                    class="px-8 py-3 bg-[#004e64] text-white font-bold rounded-lg shadow-lg hover:bg-[#003947] transition transform hover:-translate-y-1">
                    <?= $isEdit ? 'Atualizar Restaurante' : 'Cadastrar Restaurante' ?>
                </button>
            </div>

        </form>

    </main>

    <?php require_once '../components/footer.php'; ?>

</body>

</html>