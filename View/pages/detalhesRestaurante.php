<?php
require_once '../components/head.php';
require_once __DIR__ . '/../../Model/RestauranteModel.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: restaurantes.php');
    exit;
}

$restauranteModel = new RestauranteModel();
$restaurante = $restauranteModel->buscarRestaurantePorId($id);

if (!$restaurante) {
    header('Location: restaurantes.php');
    exit;
}
?>

<body class="min-h-screen bg-slate-100">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-5xl mx-auto px-4 py-10">

        <!-- BOTÃO VOLTAR -->
        <a href="/hackathon/View/pages/restaurantes.php"
            class="inline-block mb-6 text-[#004e64] font-semibold hover:underline">
            ← Voltar
        </a>

        <!-- BANNER -->
        <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-lg mb-8">
            <img src="<?= htmlspecialchars($restaurante['caminho_imagem']) ?>" class="w-full h-full object-cover"
                alt="<?= htmlspecialchars($restaurante['nome']) ?>">
        </div>

        <!-- CONTAINER GERAL -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8 space-y-10">

            <!-- CABEÇALHO -->
            <section>
                <h1 class="text-3xl font-bold text-[#004e64] flex items-center gap-4">
                    <?= htmlspecialchars($restaurante["nome"]) ?>
                </h1>

                <p class="text-slate-600">
                    <?= htmlspecialchars($restaurante["cidade"]) ?> • <?= htmlspecialchars($restaurante["categoria"]) ?>
                </p>

                <div class="flex items-center gap-4 mt-3">
                    <span
                        class="text-[#1b7f5f] font-semibold capitalize"><?= htmlspecialchars($restaurante["faixa_preco"]) ?></span>
                </div>
            </section>


            <!-- DESCRIÇÃO -->
            <section>
                <h2 class="text-xl font-semibold text-[#004e64] mb-2">Sobre o restaurante</h2>
                <p class="text-slate-700 leading-relaxed">
                    <?= nl2br(htmlspecialchars($restaurante["descricao"])) ?>
                </p>
            </section>

            <!-- HORÁRIO + ENDEREÇO -->
            <section class="grid md:grid-cols-2 gap-6">
                <div class="bg-slate-50 border rounded-xl p-5">
                    <h3 class="font-semibold text-[#004e64] mb-2">Horário de funcionamento</h3>
                    <p class="text-slate-700"><?= htmlspecialchars($restaurante["horario_funcionamento"]) ?></p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-5">
                    <h3 class="font-semibold text-[#004e64] mb-2">Endereço</h3>
                    <p class="text-slate-700"><?= htmlspecialchars($restaurante["endereco"]) ?></p>
                </div>
            </section>

            <!-- MAPA -->
            <section>
                <h2 class="text-xl font-semibold text-[#004e64] mb-3">Localização</h2>

                <?php require '../components/mapa.php'; ?>

                <script>
                    initMapaRoteiro([
                        {
                            nome: "<?= htmlspecialchars($restaurante["nome"]) ?>",
                            cidade: "<?= htmlspecialchars($restaurante["cidade"]) ?>",
                            coord: [<?= $restaurante["lat"] ?>, <?= $restaurante["log"] ?>]
                        }
                    ]);
                </script>
            </section>

            <!-- INPUT OCULTO PARA ENVIAR PRO PHP -->
            <input type="hidden" id="userRating" name="rating" value="0">

        </div>

    </main>

    <?php require_once '../components/footer.php'; ?>
</body>

</html>