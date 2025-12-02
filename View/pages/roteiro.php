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
        // Lista mockada (no futuro você troca pelo banco)
        $todasCidades = [
            "Campo Grande", "Dourados", "Três Lagoas", "Corumbá", "Ponta Porã",
            "Naviraí", "Aquidauana", "Bonito", "Sidrolândia", "Maracaju"
        ];
        ?>

        <form method="POST">

            <!-- MULTISELECT DE CIDADES -->
            <label class="text-sm font-semibold text-slate-600">Selecione as cidades:</label>

            <input 
                type="text" 
                id="buscaCidade" 
                placeholder="Buscar cidade..."
                class="mt-2 w-full p-2 border rounded mb-3"
            >

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

            <button 
                class="mt-6 px-6 py-2 bg-[#004e64] text-white rounded hover:bg-[#003947]">
                Gerar Roteiro
            </button>

        </form>

    </section>

    <!-- JS DO FORM -->
    

    <!-- RESULTADO -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

        <?php
        $cidadesSel = $_POST["cidades"] ?? [];
        $refeicoesSel = $_POST["refeicoes"] ?? [];

        // MOCK DOS RESTAURANTES
        $restaurantes = [
            ["nome" => "Casa do João", "cidade" => "Bonito",        "lat" => -21.126, "lng" => -56.483],
            ["nome" => "Tayama Sushi",   "cidade" => "Campo Grande", "lat" => -20.462, "lng" => -54.615],
            ["nome" => "Bistrô Pantanal","cidade" => "Corumbá",      "lat" => -19.008, "lng" => -57.651],
        ];

        $restaurantesFiltrados = array_filter($restaurantes, fn($r) =>
            in_array($r["cidade"], $cidadesSel)
        );

        $roteiroFinal = [];

        foreach ($cidadesSel as $cidade) {
            if (!isset($refeicoesSel[$cidade])) continue;

            foreach ($refeicoesSel[$cidade] as $ref) {

                $encontrado = current(array_filter(
                    $restaurantesFiltrados, fn($r) => $r["cidade"] == $cidade
                ));

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

        <section class="bg-white rounded-xl shadow p-6">

            <h2 class="text-2xl font-bold text-[#004e64] mb-4">Seu roteiro</h2>

            <!-- GRID LARGO -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                <?php foreach ($roteiroFinal as $r): ?>
                    <div class="bg-slate-50 rounded-xl p-5 border shadow-sm hover:shadow-md transition">
                        <h3 class="text-lg font-bold text-[#004e64]"><?= $r["nome"] ?></h3>
                        <p class="text-sm text-slate-700 mt-1">
                            <?= $r["cidade"] ?> — <b><?= ucfirst($r["refeicao"]) ?></b>
                        </p>
                    </div>
                <?php endforeach; ?>

            </div>

            <h3 class="text-xl font-bold mt-10 text-[#004e64]">Mapa do trajeto</h3>

            <?php require '../components/mapa.php'; ?>

            <script>
                initMapaRoteiro(<?= json_encode($roteiroFinal) ?>);
            </script>

        </section>

    <?php endif; ?>

</main>

<?php require_once '../components/footer.php'; ?>

</body>
</html>
