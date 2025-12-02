<?php require_once '../components/head.php'; ?>

<body class="min-h-screen bg-slate-100">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-6xl mx-auto px-4 mt-10">

        <div class="max-w-6xl mx-auto px-4 mt-10">

            <h1 class="text-3xl font-extrabold text-[#004e64] mb-6">
                Gerador de Roteiro Gastronômico
            </h1>

            <!-- FORM -->
            <section class="bg-white rounded-xl shadow p-6 mb-10">

                <?php
                // Lista real (mock para demonstração)
                $todasCidades = [
                    "Campo Grande",
                    "Dourados",
                    "Três Lagoas",
                    "Corumbá",
                    "Ponta Porã",
                    "Naviraí",
                    "Aquidauana",
                    "Bonito",
                    "Sidrolândia",
                    "Maracaju"
                ];
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

                    <!-- REFEIÇÕES POR CIDADE (dinâmico via JS) -->
                    <div id="refeicoesContainer" class="mt-6"></div>

                    <button class="mt-6 px-6 py-2 bg-[#004e64] text-white rounded hover:bg-[#003947]">
                        Gerar Roteiro
                    </button>

                </form>

            </section>

            <script>
                // FILTRO DE BUSCA DE CIDADES
                document.getElementById("buscaCidade").addEventListener("input", function () {
                    let filtro = this.value.toLowerCase();
                    document.querySelectorAll("#listaCidades label").forEach(l => {
                        l.style.display = l.textContent.toLowerCase().includes(filtro) ? "flex" : "none";
                    });
                });

                // REFEIÇÕES DINÂMICAS POR CIDADE
                document.querySelectorAll("input[name='cidades[]']").forEach(chk => {
                    chk.addEventListener("change", atualizarRefeicoes);
                });

                function atualizarRefeicoes() {
                    const cont = document.getElementById("refeicoesContainer");
                    cont.innerHTML = "";

                    const selecionadas = [...document.querySelectorAll("input[name='cidades[]']:checked")]
                        .map(e => e.value);

                    selecionadas.forEach(cidade => {
                        cont.innerHTML += `
            <div class="bg-slate-50 border rounded p-4 mb-3">
                <p class="font-semibold text-[#004e64] mb-2">${cidade}</p>

                <label class="flex gap-2 text-sm">
                    <input type="checkbox" name="refeicoes[${cidade}][]" value="cafe"> Café da manhã
                </label>

                <label class="flex gap-2 text-sm">
                    <input type="checkbox" name="refeicoes[${cidade}][]" value="almoco"> Almoço
                </label>

                <label class="flex gap-2 text-sm">
                    <input type="checkbox" name="refeicoes[${cidade}][]" value="jantar"> Jantar
                </label>

            </div>
        `;
                    });
                }
            </script>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

                <?php
                $cidadesSel = $_POST["cidades"] ?? [];
                $refeicoesSel = $_POST["refeicoes"] ?? [];

                // MOCK SIMULADO DO BANCO
                $restaurantes = [
                    ["nome" => "Casa do João", "cidade" => "Bonito", "lat" => -21.126, "lng" => -56.483],
                    ["nome" => "Tayama Sushi", "cidade" => "Campo Grande", "lat" => -20.462, "lng" => -54.615],
                    ["nome" => "Bistrô do Pantanal", "cidade" => "Corumbá", "lat" => -19.008, "lng" => -57.651],
                ];

                // FILTRAR SOMENTE CIDADES ESCOLHIDAS
                $restaurantesFiltrados = array_filter(
                    $restaurantes,
                    fn($r) =>
                    in_array($r["cidade"], $cidadesSel)
                );

                // GERAR ROTEIRO BASEADO NAS REFEIÇÕES
                $roteiroFinal = [];

                foreach ($cidadesSel as $cidade) {
                    if (!isset($refeicoesSel[$cidade]))
                        continue;

                    foreach ($refeicoesSel[$cidade] as $ref) {
                        $encontrado = current(array_filter($restaurantesFiltrados, fn($r) => $r["cidade"] == $cidade));
                        if ($encontrado) {
                            $roteiroFinal[] = [
                                "nome" => $encontrado["nome"],
                                "cidade" => $cidade,
                                "refeicao" => $ref,
                                "coord" => [$encontrado["lat"], $encontrado["lng"]]
                            ];
                        }
                    }
                }
                ?>

                <!-- EXIBIR RESULTADO -->
                <section class="bg-white rounded-xl shadow p-6">

                    <h2 class="text-2xl font-bold text-[#004e64] mb-4">Seu roteiro</h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <?php foreach ($roteiroFinal as $r): ?>
                            <div class="bg-slate-50 rounded-xl p-4 border">
                                <h3 class="text-lg font-bold text-[#004e64]"><?= $r["nome"] ?></h3>
                                <p class="text-sm"><?= $r["cidade"] ?> — <b><?= ucfirst($r["refeicao"]) ?></b></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h3 class="text-xl font-bold mt-10 text-[#004e64]">Mapa do trajeto</h3>

                    <?php require '../components/mapa.php'; ?>

                    <script>
                        initMapaRoteiro(<?= json_encode($roteiroFinal) ?>)
                    </script>

                </section>

            <?php endif; ?>
    </main>
    <?php require_once '../components/footer.php'; ?>
</body>

</html>