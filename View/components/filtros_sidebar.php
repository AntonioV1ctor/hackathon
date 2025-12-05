<form action="/hackathon/View/pages/restaurantes.php" method="GET" class="h-full">

    <section class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 h-full">

        <h2 class="text-xl font-bold text-[#004e64] mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filtros
        </h2>

        <div class="flex flex-col gap-6">

            <div>
                <label class="text-sm font-medium text-slate-600 mb-2 block">
                    Buscar
                </label>
                <input name="q" id="search"
                    class="w-full p-2 px-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#00a6bf] outline-none transition"
                    placeholder="Prato, nome..." value="<?php echo htmlspecialchars($_GET['q'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium text-slate-600 mb-2 block">
                    Cidade
                </label>
                <select name="cidade" id="filter-city"
                    class="w-full p-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#00a6bf] outline-none transition">
                    <option value="">Todas</option>
                    <?php
                    $jsonPath = __DIR__ . '/../../data/cidades.json';
                    if (file_exists($jsonPath)) {
                        $jsonContent = file_get_contents($jsonPath);
                        $data = json_decode($jsonContent, true);
                        if (isset($data['estados'][0]['cidades'])) {
                            $cidadeSelecionada = $_GET['cidade'] ?? '';
                            foreach ($data['estados'][0]['cidades'] as $cidade) {
                                $selected = $cidade === $cidadeSelecionada ? 'selected' : '';
                                echo "<option value=\"$cidade\" $selected>$cidade</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-slate-600 mb-2 block">
                    Culinária
                </label>
                <select name="culinaria" id="filter-cuisine"
                    class="w-full p-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#00a6bf] outline-none transition">
                    <option value="">Todas</option>
                    <?php
                    require_once __DIR__ . '/../../Services/categoriaService.php';
                    $categorias = CategoriaService::listarCategorias();
                    $culinariaSelecionada = $_GET['culinaria'] ?? '';
                    foreach ($categorias as $cat) {
                        $selected = $cat === $culinariaSelecionada ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-slate-600 mb-2 block">
                    Preço
                </label>
                <select name="preco" id="filter-price"
                    class="w-full p-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#00a6bf] outline-none transition">
                    <option value="">Todos</option>
                    <?php
                    $faixas = [
                        1 => ['label' => 'Barato', 'symbol' => '$'],
                        2 => ['label' => 'Moderado', 'symbol' => '$$'],
                        3 => ['label' => 'Caro', 'symbol' => '$$$'],
                        4 => ['label' => 'Sofisticado', 'symbol' => '$$$$']
                    ];
                    $precoSelecionado = $_GET['preco'] ?? '';
                    foreach ($faixas as $valor => $info) {
                        $selected = (string) $valor === $precoSelecionado ? 'selected' : '';
                        echo "<option value=\"$valor\" $selected>{$info['label']} ({$info['symbol']})</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="pt-4 flex flex-col gap-3">
                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-[#00a6bf] text-white hover:bg-[#0090a4] transition font-semibold shadow-md">
                    Aplicar Filtros
                </button>

                <a href="/hackathon/View/pages/restaurantes.php"
                    class="w-full py-2.5 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition font-semibold text-center">
                    Limpar
                </a>
            </div>

        </div>

    </section>

</form>