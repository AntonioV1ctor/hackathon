<?php require_once 'View/components/head.php' ?>

<body class="bg-gradient-to-b from-[#e4f1f4] to-white text-slate-900">

  <?php require_once 'View/components/navbar.php' ?>

  <!-- DESTAQUE -->
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
        require_once 'Model/RestauranteModel.php';

        $restauranteModel = new RestauranteModel();
        $restaurantes = $restauranteModel->listarDestaques();

        if (empty($restaurantes)) {
          echo '<p class="text-slate-500 col-span-full text-center">Nenhum restaurante em destaque no momento.</p>';
        } else {
          foreach ($restaurantes as $r) {
            echo cardRestaurante(
              $r["caminho_imagem"] ?? 'https://via.placeholder.com/400x300',
              $r["nome"] ?? 'Sem nome',
              $r["cidade"] ?? '',
              $r["categoria"] ?? '',
              $r["media_avaliacao"] ?? 0,
              $r["faixa_preco"] ?? 1,
              $r["descricao"] ?? '',
              $r["id"] ?? 0
            );
          }
        }
        ?>

      </div>

    </section>

    <?php require_once 'View/components/bannerEventos.php' ?>

    <?php require_once 'View/components/bannerMapa.php' ?>

    <?php require_once 'View/components/modal.php' ?>
  </main>

  <?php require_once 'View/components/footer.php' ?>

</body>

</html>