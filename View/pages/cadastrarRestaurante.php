<?php
// Verifica se foi enviado (Simulação de backend)
$sucesso = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui entraria o INSERT no banco de dados
    $sucesso = true;
}

require_once '../components/head.php';
?>



<body class="min-h-screen bg-slate-100 font-sans">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-4xl mx-auto px-4 py-10">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#004e64]">Novo Restaurante</h1>
                <p class="text-slate-500">Preencha as informações para cadastrar um novo estabelecimento.</p>
            </div>
            <a href="/hackathon/View/pages/Administracao.php" class="text-sm text-slate-500 hover:text-[#004e64]">
                cancelar
            </a>
        </div>

        <?php if ($sucesso): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Restaurante cadastrado com sucesso!</span>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold text-[#004e64] mb-4 border-b pb-2">Dados Gerais</h2>

                <div class="grid md:grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nome do Restaurante</label>
                        <input type="text" name="nome" required placeholder="Ex: Casa do João"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Cidade</label>
                        <select name="cidade"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                            <option value="Bonito">Bonito</option>
                            <option value="Campo Grande">Campo Grande</option>
                            <option value="Dourados">Dourados</option>
                            <option value="Corumbá">Corumbá</option>
                            <option value="Ponta Porã">Ponta Porã</option>
                        </select>
                    </div>


                    <?php
                    // ... require_once ...
                    
                    // MOCK: Substituir depois pelo SELECT do banco
// $sql = "SELECT id, nome FROM categorias ORDER BY nome ASC";
                    $categorias_db = [
                        ["id" => 1, "nome" => "Pantaneira"],
                        ["id" => 2, "nome" => "Peixes e Frutos do Mar"],
                        ["id" => 3, "nome" => "Churrascaria"],
                        ["id" => 4, "nome" => "Comida Caseira"],
                        ["id" => 5, "nome" => "Italiana / Massas"],
                        ["id" => 6, "nome" => "Japonesa"],
                        ["id" => 7, "nome" => "Lanches e Porções"],
                        ["id" => 8, "nome" => "Vegetariana / Vegana"],
                    ];
                    ?>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Categoria (Culinária)</label>

                        <select name="categoria_id" required
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">

                            <option value="" disabled selected>Selecione uma categoria...</option>

                            <?php foreach ($categorias_db as $cat): ?>
                                <option value="<?= $cat['id'] ?>">
                                    <?= $cat['nome'] ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Faixa de Preço</label>
                        <select name="preco"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                            <option value="R$">Barato (R$)</option>
                            <option value="R$$">Moderado (R$$)</option>
                            <option value="R$$$">Caro (R$$$)</option>
                            <option value="R$$$$">Sofisticado (R$$$$)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Horário de Funcionamento</label>
                        <input type="text" name="horario" placeholder="Ex: 11:00 às 23:00"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Descrição</label>
                        <textarea name="descricao" rows="3"
                            placeholder="Conte um pouco sobre a história e o ambiente..."
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64] resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold text-[#004e64] mb-4 border-b pb-2">Localização</h2>

                <div class="grid md:grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Endereço Completo</label>
                        <input type="text" name="endereco" placeholder="Rua, Número, Bairro"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Latitude</label>
                        <input type="text" name="lat" placeholder="-21.12345"
                            class="w-full rounded-md border-slate-300 shadow-sm focus:border-[#004e64] focus:ring-[#004e64]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Longitude</label>
                        <input type="text" name="lng" placeholder="-56.12345"
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
                        <input type="file" name="foto_capa" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#004e64] file:text-white hover:file:bg-[#003947] transition">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-xl font-semibold text-[#004e64]">Cardápio Rápido</h2>
                    <button type="button" onclick="addMenuItem()"
                        class="text-sm text-[#004e64] font-semibold hover:underline">+ Adicionar Item</button>
                </div>

                <div id="menu-container" class="space-y-3">
                    <div class="menu-item flex gap-3">
                        <input type="text" name="prato_nome[]" placeholder="Nome do Prato"
                            class="flex-1 rounded-md border-slate-300 shadow-sm text-sm">
                        <input type="text" name="prato_preco[]" placeholder="Preço (R$)"
                            class="w-32 rounded-md border-slate-300 shadow-sm text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 pb-12">
                <button type="submit"
                    class="px-8 py-3 bg-[#004e64] text-white font-bold rounded-lg shadow-lg hover:bg-[#003947] transition transform hover:-translate-y-1">
                    Cadastrar Restaurante
                </button>
            </div>

        </form>

    </main>

    <?php require_once '../components/footer.php'; ?>

    <script>
        function addMenuItem() {
            const container = document.getElementById('menu-container');

            const div = document.createElement('div');
            div.className = 'menu-item flex gap-3 animate-fade-in-down'; // animate classe opcional se tiver config

            div.innerHTML = `
                <input type="text" name="prato_nome[]" placeholder="Nome do Prato" class="flex-1 rounded-md border-slate-300 shadow-sm text-sm">
                <input type="text" name="prato_preco[]" placeholder="Preço (R$)" class="w-32 rounded-md border-slate-300 shadow-sm text-sm">
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold px-2">✕</button>
            `;

            container.appendChild(div);
        }
    </script>
</body>

</html>