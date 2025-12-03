<?php require_once '../components/head.php'; ?>

<body class="min-h-screen bg-slate-100">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-5xl mx-auto px-4 py-10">

        <?php
        // MOCK DO RESTAURANTE — substituir depois pelo SELECT do banco
        $restaurante = [
            "nome" => "Casa do João",
            "cidade" => "Bonito",
            "culinaria" => "Pantaneira",
            "descricao" => "Um dos restaurantes mais tradicionais de Bonito, famoso pelos pratos regionais com ingredientes locais frescos.",
            "img" => "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&w=1200",
            "galeria" => [
                "https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&w=900",
                "https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&w=900",
                "https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&w=900"
            ],
            "preco" => "R$$",
            "rating" => 5,
            "horario" => "11:00 às 22:00",
            "endereco" => "Av. Principal, 123 — Bonito, MS",
            "lat" => -21.126,
            "lng" => -56.483,

            "cardapio" => [
                ["nome" => "Pacu na Brasa", "preco" => "R$ 49,00"],
                ["nome" => "Moqueca Pantaneira", "preco" => "R$ 59,00"],
                ["nome" => "Sobremesa de Guavira", "preco" => "R$ 22,00"],
            ]
        ];
        ?>

        <!-- BOTÃO VOLTAR -->
        <a href="/hackathon/View/pages/restaurantes.php"
            class="inline-block mb-6 text-[#004e64] font-semibold hover:underline">
            ← Voltar
        </a>

        <!-- BANNER -->
        <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-lg mb-8">
            <img src="<?= $restaurante['img'] ?>" class="w-full h-full object-cover">
        </div>

        <!-- CONTAINER GERAL -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8 space-y-10">

            <!-- CABEÇALHO -->
            <section>
                <h1 class="text-3xl font-bold text-[#004e64] flex items-center gap-4">
                    <?= $restaurante["nome"] ?>


                </h1>

                <p class="text-slate-600">
                    <?= $restaurante["cidade"] ?> • <?= $restaurante["culinaria"] ?>
                </p>

                <div class="flex items-center gap-4 mt-3">
                    <!-- AVALIAÇÃO MÉDIA (fixa do restaurante) -->
                    <span class="text-yellow-400 text-xl">
                        <?= str_repeat("★", $restaurante["rating"]) ?>
                        <?= str_repeat("☆", 5 - $restaurante["rating"]) ?>
                    </span>

                    <span class="text-[#1b7f5f] font-semibold"><?= $restaurante["preco"] ?></span>
                </div>
            </section>


            <!-- DESCRIÇÃO -->
            <section>
                <h2 class="text-xl font-semibold text-[#004e64] mb-2">Sobre o restaurante</h2>
                <p class="text-slate-700 leading-relaxed">
                    <?= $restaurante["descricao"] ?>
                </p>
            </section>

            <!-- HORÁRIO + ENDEREÇO -->
            <section class="grid md:grid-cols-2 gap-6">
                <div class="bg-slate-50 border rounded-xl p-5">
                    <h3 class="font-semibold text-[#004e64] mb-2">Horário de funcionamento</h3>
                    <p class="text-slate-700"><?= $restaurante["horario"] ?></p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-5">
                    <h3 class="font-semibold text-[#004e64] mb-2">Endereço</h3>
                    <p class="text-slate-700"><?= $restaurante["endereco"] ?></p>
                </div>
            </section>

            <!-- MAPA -->
            <section>
                <h2 class="text-xl font-semibold text-[#004e64] mb-3">Localização</h2>

                <?php require '../components/mapa.php'; ?>

                <script>
                    initMapaRoteiro([
                        {
                            nome: "<?= $restaurante["nome"] ?>",
                            cidade: "<?= $restaurante["cidade"] ?>",
                            coord: [<?= $restaurante["lat"] ?>, <?= $restaurante["lng"] ?>]
                        }
                    ]);
                </script>
            </section>

            <!-- CARDÁPIO -->
            <section>
                <h2 class="text-xl font-semibold text-[#004e64] mb-3">Cardápio</h2>

                <div class="space-y-3">

                    <?php foreach ($restaurante["cardapio"] as $item): ?>
                        <div class="flex justify-between bg-slate-50 border rounded-xl p-3">
                            <span class="font-medium text-slate-700"><?= $item["nome"] ?></span>
                            <span class="text-[#004e64] font-semibold"><?= $item["preco"] ?></span>
                        </div>
                    <?php endforeach; ?>

                </div>
            </section>

            <!-- AVALIAÇÃO DO USUÁRIO -->
            <section class="flex items-center justify-between bg-slate-50 border rounded-xl p-4">

                <div>
                    <h3 class="font-semibold text-[#004e64]">Avalie este restaurante</h3>
                    <p class="text-xs text-slate-500">Clique nas estrelas para avaliar</p>
                </div>

                <!-- ESTRELAS INTERATIVAS -->
                <div id="ratingStars" class="flex gap-1 text-3xl cursor-pointer select-none">
                    <span data-star="1" class="star text-slate-300 hover:text-yellow-400 transition">★</span>
                    <span data-star="2" class="star text-slate-300 hover:text-yellow-400 transition">★</span>
                    <span data-star="3" class="star text-slate-300 hover:text-yellow-400 transition">★</span>
                    <span data-star="4" class="star text-slate-300 hover:text-yellow-400 transition">★</span>
                    <span data-star="5" class="star text-slate-300 hover:text-yellow-400 transition">★</span>
                </div>

            </section>

            <!-- INPUT OCULTO PARA ENVIAR PRO PHP -->
            <input type="hidden" id="userRating" name="rating" value="0">

        </div>

    </main>

    <?php require_once '../components/footer.php'; ?>
</body>

</html>