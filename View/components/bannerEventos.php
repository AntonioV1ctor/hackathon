<?php
// MOCK de eventos
$eventos = [
    [
        "titulo" => "Festival Gastronômico de Bonito",
        "data"   => "12 a 15 de Março",
        "local"  => "Bonito - MS",
        "img"    => "https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?auto=format&w=1200"
    ],
    [
        "titulo" => "Feira do Peixe Pantaneiro",
        "data"   => "22 a 24 de Abril",
        "local"  => "Corumbá - MS",
        "img"    => "https://images.unsplash.com/photo-1533777324565-a040eb52fac1?auto=format&w=1200"
    ],
    [
        "titulo" => "Semana da Culinária Sul-Mato-Grossense",
        "data"   => "10 a 13 de Agosto",
        "local"  => "Campo Grande - MS",
        "img"    => "https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&w=1200"
    ]
];
?>

<section class="relative max-w-7xl mx-auto px-4 md:px-6 mt-20">

    <h2 class="text-3xl font-extrabold text-[#004e64] mb-6">
        Eventos Gastronômicos
    </h2>

    <div class="relative overflow-hidden rounded-2xl shadow-lg">

        <!-- Carrossel -->
        <div id="carouselEventos" class="flex transition-all duration-700">

            <?php foreach ($eventos as $ev): ?>
                <div class="flex-none w-full relative h-72 md:h-96">

                    <img src="<?= $ev['img'] ?>" 
                         class="absolute inset-0 w-full h-full object-cover">

                    <div class="absolute inset-0 bg-black/50"></div>

                    <div class="absolute bottom-6 left-6 text-white drop-shadow-lg">
                        <h3 class="text-2xl md:text-3xl font-bold"><?= $ev['titulo'] ?></h3>
                        <p class="text-sm md:text-base mt-1"><?= $ev['data'] ?></p>
                        <p class="text-sm md:text-base opacity-90"><?= $ev['local'] ?></p>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- SETAS -->
        <button id="prevEvento"
            class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/40 backdrop-blur 
                   text-white rounded-full p-2 hover:bg-black/60 transition">
            ‹
        </button>

        <button id="nextEvento"
            class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/40 backdrop-blur 
                   text-white rounded-full p-2 hover:bg-black/60 transition">
            ›
        </button>

    </div>
</section>

<script>
let indexEv = 0;
const sliderEv = document.getElementById("carouselEventos");
const totalEv = <?= count($eventos) ?>;

// AVANÇAR
document.getElementById("nextEvento").onclick = () => {
    indexEv = (indexEv + 1) % totalEv;
    sliderEv.style.transform = `translateX(-${indexEv * 100}%)`;
};

// VOLTAR
document.getElementById("prevEvento").onclick = () => {
    indexEv = (indexEv - 1 + totalEv) % totalEv;
    sliderEv.style.transform = `translateX(-${indexEv * 100}%)`;
};

// AUTOPLAY
setInterval(() => {
    indexEv = (indexEv + 1) % totalEv;
    sliderEv.style.transform = `translateX(-${indexEv * 100}%)`;
}, 6000);
</script>
