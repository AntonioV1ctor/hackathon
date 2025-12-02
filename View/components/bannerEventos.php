<section class="relative h-[55vh] md:h-[65vh] overflow-hidden flex items-center">

    <!-- Fundo com imagem temática do MS -->
    <div class="absolute inset-0 -z-10">
        <img 
            src="https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?auto=format&fit=crop&w=1920&q=70"
            class="w-full h-full object-cover"
            alt="Eventos Gastronômicos MS"
        >
    </div>

    <!-- Overlay degradê -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>

    <!-- Conteúdo -->
    <div class="relative z-10 px-8 md:px-16 max-w-4xl text-white">

        <span class="inline-flex items-center gap-2 bg-[#f2c14e] text-black font-semibold px-4 py-1 rounded-full text-sm shadow">
            🎉 Eventos no MS
        </span>

        <h2 class="text-4xl md:text-5xl font-extrabold mt-4 drop-shadow-lg leading-tight">
            Gastronomia, Cultura & Tradição  
        </h2>

        <p class="mt-4 text-lg md:text-xl text-white/90 drop-shadow">
            Descubra os melhores festivais gastronômicos, feiras culturais e eventos regionais acontecendo em Mato Grosso do Sul.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4">

            <a href="/eventos"
                class="px-6 py-3 rounded-lg bg-[#00a6bf] text-black font-semibold shadow hover:brightness-95 transition flex items-center gap-2">
                📅 Ver eventos disponíveis
            </a>

            <a href="/eventos/calendario"
                class="px-6 py-3 rounded-lg bg-white/20 border border-white text-white font-semibold shadow hover:bg-white/30 transition flex items-center gap-2">
                🗓️ Calendário completo
            </a>

        </div>

    </div>

</section>
