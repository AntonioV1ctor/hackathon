<?php require_once '../components/head.php'; ?>

<body class="bg-slate-100">

<?php require_once '../components/navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-extrabold text-[#004e64] mb-6">
        Restaurantes
    </h1>

    <?php require_once '../components/filtros.php'; ?>

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
    <section class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <?php
        require_once '../components/cardRestaurante.php';

        if (empty($filtrados)) {
            echo "<p class='text-slate-500 text-lg'>Nenhum resultado encontrado.</p>";
        }

        foreach ($filtrados as $r) {
            // Mapeamento dos campos do banco para o componente card
            // O componente espera: img, nome, cidade, culinaria, rating, preco, desc, id
            // No banco: caminho_imagem, nome, cidade, categoria, media_avaliacao (calculado), faixa_preco, descricao, id
            
            // Tratamento do preço para exibir cifrões
            $precoSimbolo = '';
            switch($r['faixa_preco']) {
                case 'barato': $precoSimbolo = 1; break;
                case 'moderado': $precoSimbolo = 2; break;
                case 'caro': $precoSimbolo = 3; break;
                case 'sofisticado': $precoSimbolo = 4; break;
                default: $precoSimbolo = 1;
            }

            echo cardRestaurante(
                $r["caminho_imagem"] ?? 'https://via.placeholder.com/400x300', // Fallback image
                $r["nome"],
                $r["cidade"],
                $r["categoria"],
                round($r["media_avaliacao"] ?? 0), // Arredonda a média
                $precoSimbolo,
                $r["descricao"],
                $r["id"]
            );
        }
        ?>
    </section>

</main>

<?php require_once '../components/footer.php'; ?>

</body>
</html>
