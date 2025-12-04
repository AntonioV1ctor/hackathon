<?php require_once '../components/head.php'; ?>

<body class="min-h-screen flex flex-col bg-slate-100">

    <?php require_once '../components/navbar.php'; ?>

    <main class="flex-1 max-w-7xl mx-auto px-4 mt-10">

        <h1 class="text-3xl font-extrabold text-[#004e64] mb-6">
            Gerador de Roteiro Gastronômico
        </h1>

        <!-- FORM -->
        <section class="bg-white rounded-xl shadow p-6 mb-10">

            <?php
            // Carregar cidades do JSON
            $todasCidades = [];
            $jsonPath = __DIR__ . '/../../data/cidades.json';
            if (file_exists($jsonPath)) {
                $jsonContent = file_get_contents($jsonPath);
                $data = json_decode($jsonContent, true);
                if (isset($data['estados'][0]['cidades'])) {
                    $todasCidades = $data['estados'][0]['cidades'];
                    sort($todasCidades); // Ordenar alfabeticamente
                }
            }
            ?>

            <form method="POST">

                <!-- MULTISELECT DE CIDADES -->
                <label class="text-sm font-semibold text-slate-600">Selecione as cidades:</label>

                <input type="text" id="buscaCidade" placeholder="Buscar cidade..."
                    class="mt-2 w-full p-2 border rounded mb-3">

                <div id="listaCidades" class="max-h-40 overflow-y-auto border rounded p-2 bg-white">
                    <?php foreach ($todasCidades as $c): ?>
                        <label class="flex items-center gap-2 text-sm p-1 cursor-pointer hover:bg-slate-100 rounded">
                            <input type="checkbox" name="cidades[]" value="<?= $c ?>" class="accent-[#004e64]">
                            <?= $c ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- REFEIÇÕES POR CIDADE -->
                <div id="refeicoesContainer" class="mt-6"></div>

                <button class="mt-6 px-6 py-2 bg-[#004e64] text-white rounded hover:bg-[#003947]">
                    Gerar Roteiro
                </button>

            </form>

        </section>

        <!-- JS DO FORM -->
        <script>
            const checkboxes = document.querySelectorAll('input[name="cidades[]"]');
            const container = document.getElementById('refeicoesContainer');
            const buscaInput = document.getElementById('buscaCidade');
            const listaCidades = document.getElementById('listaCidades');

            // Filtro de cidades
            buscaInput.addEventListener('input', (e) => {
                const termo = e.target.value.toLowerCase();
                const labels = listaCidades.querySelectorAll('label');
                labels.forEach(label => {
                    const texto = label.textContent.trim().toLowerCase();
                    label.style.display = texto.includes(termo) ? 'flex' : 'none';
                });
            });

            // Gerar campos de refeição dinamicamente
            checkboxes.forEach(cb => {
                cb.addEventListener('change', (e) => {
                    toggleRefeicao(e.target);
                });
            });

            function toggleRefeicao(checkbox) {
                const cidade = checkbox.value;
                // Sanitizar o nome da cidade para usar como ID (remover espaços e acentos)
                const cidadeId = 'ref-' + cidade.replace(/[^a-zA-Z0-9]/g, '');

                if (checkbox.checked) {
                    // Adicionar
                    if (!document.getElementById(cidadeId)) {
                        const div = document.createElement('div');
                        div.id = cidadeId;
                        div.className = 'mb-4 p-3 bg-slate-50 rounded border animate-fade-in';

                        div.innerHTML = `
                            <p class="font-bold text-[#004e64] mb-2">${cidade}</p>
                            <div class="flex flex-wrap gap-3">
                                <label class="flex items-center gap-1 text-sm">
                                    <input type="checkbox" name="refeicoes[${cidade}][]" value="almoco" checked> Almoço
                                </label>
                                <label class="flex items-center gap-1 text-sm">
                                    <input type="checkbox" name="refeicoes[${cidade}][]" value="jantar"> Jantar
                                </label>
                                <label class="flex items-center gap-1 text-sm">
                                    <input type="checkbox" name="refeicoes[${cidade}][]" value="cafe"> Café
                                </label>
                            </div>
                        `;
                        container.appendChild(div);
                    }
                } else {
                    // Remover
                    const el = document.getElementById(cidadeId);
                    if (el) {
                        el.remove();
                    }
                }

                // Gerenciar visibilidade do título
                let titulo = document.getElementById('titulo-refeicoes');
                const temSelecionados = container.children.length > 0; // Check children count directly, but title might be one child

                // Better check: do we have any divs starting with ref-?
                const hasRefDivs = Array.from(container.children).some(child => child.id && child.id.startsWith('ref-'));

                if (hasRefDivs) {
                    if (!titulo) {
                        titulo = document.createElement('h3');
                        titulo.id = 'titulo-refeicoes';
                        titulo.className = 'text-sm font-semibold text-slate-600 mb-3';
                        titulo.textContent = 'O que deseja comer em cada cidade?';
                        container.insertBefore(titulo, container.firstChild);
                    }
                } else {
                    if (titulo) titulo.remove();
                }
            }
        </script>

        <!-- RESULTADO -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

            <?php
            require_once '../../Model/restauranteModel.php';
            $restauranteModel = new RestauranteModel();

            $cidadesSel = $_POST["cidades"] ?? [];
            $refeicoesSel = $_POST["refeicoes"] ?? [];

            // Buscar todos os restaurantes do banco
            $todosRestaurantes = $restauranteModel->listarRestaurantes();

            // Filtrar apenas restaurantes das cidades selecionadas
            $restaurantesFiltrados = array_filter(
                $todosRestaurantes,
                fn($r) =>
                in_array($r["cidade"], $cidadesSel)
            );

            $roteiroFinal = [];

            foreach ($cidadesSel as $cidade) {
                if (!isset($refeicoesSel[$cidade]))
                    continue;

                // Encontrar restaurantes desta cidade
                $opcoesCidade = array_filter($restaurantesFiltrados, fn($r) => $r["cidade"] == $cidade);

                // Se não houver restaurantes nesta cidade, pular
                if (empty($opcoesCidade))
                    continue;

                foreach ($refeicoesSel[$cidade] as $ref) {
                    // Selecionar um restaurante aleatório ou o primeiro disponível para variar
                    // Aqui pegamos um aleatório para ser mais dinâmico
                    $chaveAleatoria = array_rand($opcoesCidade);
                    $encontrado = $opcoesCidade[$chaveAleatoria];

                    if ($encontrado) {
                        $roteiroFinal[] = [
                            "nome" => $encontrado["nome"],
                            "cidade" => $cidade,
                            "refeicao" => $ref,
                            "coord" => [$encontrado["lat"], $encontrado["log"]], // Note: Model usa 'log' e não 'lng'
                            "imagem" => $encontrado["caminho_imagem"] ?? '',
                            "id" => $encontrado["id"]
                        ];
                    }
                }
            }
            ?>

            <section class="bg-white rounded-xl shadow p-6 mb-10">

                <h2 class="text-2xl font-bold text-[#004e64] mb-4">Seu roteiro</h2>

                <?php if (empty($roteiroFinal)): ?>
                    <p class="text-slate-500">Não encontramos restaurantes cadastrados para as cidades selecionadas.</p>
                <?php else: ?>

                    <!-- GRID LARGO -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                        <?php foreach ($roteiroFinal as $r): ?>
                            <div class="bg-slate-50 rounded-xl p-5 border shadow-sm hover:shadow-md transition">
                                <h3 class="text-lg font-bold text-[#004e64]"><?= $r["nome"] ?></h3>
                                <p class="text-sm text-slate-700 mt-1">
                                    <?= $r["cidade"] ?> — <b class="capitalize"><?= $r["refeicao"] ?></b>
                                </p>
                                <a href="/hackathon/View/pages/detalhesRestaurante.php?id=<?= $r['id'] ?>"
                                    class="mt-3 inline-block text-sm font-semibold text-[#00a6bf] hover:underline">
                                    Ver detalhes &rarr;
                                </a>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <h3 class="text-xl font-bold mt-10 text-[#004e64] mb-4">Mapa do trajeto</h3>

                    <!-- Container para o mapa do roteiro -->
                    <div id="mapaRoteiro" class="w-full h-96 rounded-xl shadow-inner border z-0"></div>

                    <!-- Leaflet CSS & JS (se ainda não estiverem carregados no head/footer, mas aqui garantimos) -->
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const roteiro = <?= json_encode($roteiroFinal) ?>;

                            if (roteiro.length > 0) {
                                const mapRoteiro = L.map('mapaRoteiro');

                                // Adicionar tile layer
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap contributors'
                                }).addTo(mapRoteiro);

                                const markers = [];
                                const latlngs = [];

                                roteiro.forEach(item => {
                                    if (item.coord && item.coord[0] && item.coord[1]) {
                                        const lat = parseFloat(item.coord[0]);
                                        const lng = parseFloat(item.coord[1]);

                                        if (!isNaN(lat) && !isNaN(lng)) {
                                            const marker = L.marker([lat, lng]).addTo(mapRoteiro);
                                            marker.bindPopup(`<b>${item.nome}</b><br>${item.cidade} - ${item.refeicao}`);
                                            markers.push(marker);
                                            latlngs.push([lat, lng]);
                                        }
                                    }
                                });

                                if (markers.length > 0) {
                                    const group = new L.featureGroup(markers);
                                    mapRoteiro.fitBounds(group.getBounds().pad(0.1));

                                    // Opcional: desenhar linha conectando os pontos se houver mais de um
                                    if (latlngs.length > 1) {
                                        L.polyline(latlngs, { color: '#004e64', weight: 3, opacity: 0.7, dashArray: '10, 10' }).addTo(mapRoteiro);
                                    }
                                } else {
                                    // Fallback se não houver coordenadas válidas
                                    mapRoteiro.setView([-20.4697, -54.6201], 6);
                                }
                            }
                        });
                    </script>

                <?php endif; ?>

            </section>

        <?php endif; ?>

    </main>

    <?php require_once '../components/footer.php'; ?>

</body>

</html>