<?php require_once '../components/head.php'; ?>

<body class="bg-slate-100">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-10">

        <h1 class="text-3xl font-extrabold text-[#004e64] mb-8">
            Restaurantes
        </h1>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Sidebar Filtros -->
            <aside class="w-full lg:w-1/4 shrink-0">
                <?php require_once '../components/filtros_sidebar.php'; ?>
            </aside>

            <!-- Lista de Restaurantes -->
            <div class="flex-1">
                <?php
                require_once '../../Model/restauranteModel.php';

                $restauranteModel = new RestauranteModel();

                // FILTROS RECEBIDOS
                $filtros = [
                    'q' => $_GET["q"] ?? "",
                    'cidade' => $_GET["cidade"] ?? "",
                    'culinaria' => $_GET["culinaria"] ?? "",
                    'preco' => $_GET["preco"] ?? "",
                    'rating' => $_GET["rating"] ?? ""
                ];

                // BUSCAR NO BANCO
                $filtrados = $restauranteModel->buscarRestaurantesPorFiltro($filtros);
                ?>

                <!-- GRID -->
                <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php
                    require_once '../components/cardRestaurante.php';

                    if (empty($filtrados)) {
                        echo "<div class='col-span-full text-center py-10'>";
                        echo "<p class='text-slate-500 text-lg'>Nenhum resultado encontrado para os filtros selecionados.</p>";
                        echo "</div>";
                    }

                    foreach ($filtrados as $r) {
                        // Mapeamento dos campos do banco para o componente card
                        // O componente espera: img, nome, cidade, culinaria, rating, preco, desc, id
                        // No banco: caminho_imagem, nome, cidade, categoria, media_avaliacao (calculado), faixa_preco, descricao, id
                    
                        // Tratamento do preço para exibir cifrões
                        echo cardRestaurante(
                            $r["caminho_imagem"] ?? 'https://via.placeholder.com/400x300', // Fallback image
                            $r["nome"],
                            $r["cidade"],
                            $r["categoria"],
                            round($r["media_avaliacao"] ?? 0), // Arredonda a média
                            $r["faixa_preco"], // Passa o valor cru (int ou string), o componente trata
                            $r["descricao"],
                            $r["id"]
                        );
                    }
                    ?>
                </section>
            </div>

        </div>

    </main>

    <?php require_once '../components/footer.php'; ?>

</body>

</html>