<?php require_once 'View/components/head.php' ?>

<body class="bg-gradient-to-b from-[#e4f1f4] to-white text-slate-900">

  <?php require_once 'View/components/navbar.php' ?>

  <!-- HERO -->
  <?php require_once 'View/components/hero.php' ?>


  <!-- CONTEÚDO PRINCIPAL -->
  <main class="max-w-7xl mx-auto px-4 md:px-6 mt-10">
    <?php require_once 'View/components/cardRestaurante.php' ?>

    <section class="mt-12 mb-20">
      <h2 class="text-2xl font-bold text-[#004e64] mb-6">
        Restaurantes em destaque
      </h2>

      <div id="cards" class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <?php
        require_once 'View/components/cardRestaurante.php';

        // MOCK PARA TESTAR
        $restaurantes = [
          [
            "id" => 1,
            "nome" => "Casa do João",
            "cidade" => "Bonito",
            "culinaria" => "Pantaneira",
            "rating" => 5,
            "preco" => 2,
            "img" => "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&w=900&q=60",
            "desc" => "Pratos típicos pantaneiros com ingredientes locais."
          ],
          [
            "id" => 2,
            "nome" => "Tayama Sushi MS",
            "cidade" => "Campo Grande",
            "culinaria" => "Japonês / Sushi",
            "rating" => 4,
            "preco" => 3,
            "img" => "https://images.unsplash.com/photo-1555992336-cbfcd98a6e56?auto=format&w=900&q=60",
            "desc" => "Sushi com toque regional e peixes frescos."
          ],
          [
            "id" => 3,
            "nome" => "Churrascaria do Sul",
            "cidade" => "Campo Grande",
            "culinaria" => "Churrasco",
            "rating" => 5,
            "preco" => 3,
            "img" => "https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&w=900&q=60",
            "desc" => "Rodízio premium com cortes nobres."
          ],
          [
            "id" => 4,
            "nome" => "Bistrô do Pantanal",
            "cidade" => "Corumbá",
            "culinaria" => "Peixes & Regional",
            "rating" => 4,
            "preco" => 2,
            "img" => "https://images.unsplash.com/photo-1458642849426-cfb724f15ef7?auto=format&w=900&q=60",
            "desc" => "Peixes locais e pratos criativos do Pantanal."
          ]
        ];

        foreach ($restaurantes as $r) {
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

      </div>

    </section>

    <?php require_once 'View/components/bannerEventos.php' ?>


    <?php require_once 'View/components/modal.php' ?>
  </main>

  <?php require_once 'View/components/footer.php' ?>

</body>

</html>