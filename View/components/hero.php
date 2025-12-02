<section class="relative h-[75vh] overflow-hidden flex items-center justify-center">

    <!-- Vídeo de fundo -->
    <div class="absolute inset-0 -z-10 pointer-events-none">
        <iframe 
            class="w-full h-full object-cover"
            src="https://www.youtube.com/embed/n694VN8nUt0?autoplay=1&mute=1&loop=1&playlist=n694VN8nUt0&controls=0&showinfo=0&modestbranding=1"
            frameborder="0"
            allow="autoplay; fullscreen; loop"
            allowfullscreen>
        </iframe>
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black/40"></div>

    <!-- Conteúdo principal -->
    <div class="relative z-10 text-center text-white px-6 max-w-4xl">
        
        <h1 class="text-5xl md:text-6xl font-extrabold drop-shadow-lg leading-tight">
            Sabores do Mato Grosso do Sul
        </h1>

        <p class="mt-4 text-lg md:text-xl text-white/90 drop-shadow">
            Gastronomia pantaneira, cultura e experiências únicas em um só lugar.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">

            <a href="#lista"
                class="flex items-center gap-2 px-6 py-3 rounded-lg bg-[#00a6bf] 
                       text-black font-semibold shadow hover:brightness-95 transition">
                🍽️ Explorar Restaurantes
            </a>

            <a href="#lista"
                class="flex items-center gap-2 px-6 py-3 rounded-lg bg-[#f2c14e] 
                       text-black font-semibold shadow hover:brightness-95 transition">
                🗺️ Roteiros & Cidades
            </a>

        </div>

    </div>

</section>


<!-- FILTRO FLUTUANTE SOBRE A HERO -->
<div class="relative z-20 flex justify-center -mt-24 px-4">
    <div class="max-w-6xl w-full">
        <?php require_once 'view/components/filtros.php' ?>
    </div>
</div>
