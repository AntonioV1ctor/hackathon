<?php require_once '../components/head.php'; ?>

<body class="bg-slate-100">

<?php require_once '../components/navbar.php'; ?>

<main class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-extrabold text-[#004e64] mb-6">
        Restaurantes
    </h1>

    <?php require_once '../components/filtros.php'; ?>

    <?php
    // MOCK (substituir por SELECT no banco)
    $restaurantes = [
        [
            "id" => 1,
            "nome" => "Casa do João",
            "cidade" => "Bonito",
            "culinaria" => "Pantaneira",
            "preco" => 2,
            "rating" => 5,
            "img" => "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&w=900",
            "desc" => "Pratos típicos regionais."
        ],
        [
            "id" => 2,
            "nome" => "Tayama Sushi",
            "cidade" => "Campo Grande",
            "culinaria" => "Japonês",
            "preco" => 3,
            "rating" => 4,
            "img" => "https://images.unsplash.com/photo-1555992336-cbfcd98a6e56?auto=format&w=900",
            "desc" => "Sushi com toque regional."
        ],
    ];

    // FILTROS RECEBIDOS
    $q        = $_GET["q"] ?? "";
    $cidade   = $_GET["cidade"] ?? "";
    $culinaria = $_GET["culinaria"] ?? "";
    $preco    = $_GET["preco"] ?? "";
    $rating   = $_GET["rating"] ?? "";

    // FILTRAR
    $filtrados = array_filter($restaurantes, function ($r) use ($q, $cidade, $culinaria, $preco, $rating) {

        if ($q && !str_contains(strtolower($r["nome"] . $r["desc"]), strtolower($q)))
            return false;

        if ($cidade && $cidade !== $r["cidade"])
            return false;

        if ($culinaria && $culinaria !== $r["culinaria"])
            return false;

        if ($preco && intval($preco) !== intval($r["preco"]))
            return false;

        if ($rating && intval($rating) > intval($r["rating"]))
            return false;

        return true;
    });
    ?>

    <!-- GRID -->
    <section class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <?php
        require_once '../components/cardRestaurante.php';

        if (empty($filtrados)) {
            echo "<p class='text-slate-500 text-lg'>Nenhum resultado encontrado.</p>";
        }

        foreach ($filtrados as $r) {
            echo cardRestaurante(
                $r["img"],
                $r["nome"],
                $r["cidade"],
                $r["culinaria"],
                $r["rating"],
                $r["preco"],
                $r["desc"],
                $r["id"]
            );
        }
        ?>
    </section>

</main>

<?php require_once '../components/footer.php'; ?>

</body>
</html>
