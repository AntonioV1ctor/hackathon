<?php
// Garante que a sessão esteja iniciada para ler os dados do usuário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// LÓGICA DE PERMISSÃO
// Ajuste 'nivel' para o nome exato que você usa no seu Login (ex: 'role', 'tipo', etc)
$isAdmin = isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin';
?>

<header class="bg-white/95 backdrop-blur sticky top-0 z-[1000] shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 relative flex items-center justify-between">

        <a href="/hackathon/index.php" class="flex items-center gap-3 group">
            <img src="https://img.icons8.com/fluency/48/restaurant.png"
                class="h-9 w-9 transform group-hover:scale-105 transition" alt="Logo">

            <div>
                <h1 class="text-lg font-bold text-[#004e64] group-hover:text-[#007889] transition">
                    Gastronomia MS
                </h1>
                <p class="text-xs text-[#6b7280]">Turismo gastronômico • Mato Grosso do Sul</p>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-[#6b7280]">
            <a href="/hackathon" class="hover:text-[#00a6bf] transition">Início</a>
            <a href="/hackathon/view/pages/restaurantes.php" class="hover:text-[#00a6bf] transition">Restaurantes</a>
            <a href="/hackathon/view/pages/roteiro.php" class="hover:text-[#00a6bf] transition">Roteiros</a>

            <?php if ($isAdmin): ?>
                <a href="/hackathon/view/admin/cadastrar_restaurante.php" 
                   class="text-emerald-600 font-bold hover:text-emerald-700 transition flex items-center gap-1">
                   <span>+</span> Novo Restaurante
                </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="/hackathon/Controller/sairController.php"
                    class="px-4 py-2 rounded-md border border-[#004e64] text-[#004e64] hover:bg-slate-50 transition shadow">
                    Sair
                </a>
            <?php else: ?>
                <a href="/hackathon/view/pages/login.php"
                    class="px-4 py-2 rounded-md bg-[#004e64] text-white hover:bg-[#003947] transition shadow">
                    Entrar
                </a>
            <?php endif; ?>
        </nav>

        <button id="mobile-btn" class="md:hidden p-2 text-[#004e64] focus:outline-none">
            <svg id="icon-open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="icon-close" class="hidden w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

    </div>

    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-white border-t border-slate-200 shadow-xl z-[999]">
        <nav class="flex flex-col p-4 space-y-3 font-medium text-[#6b7280]">
            <a href="/hackathon" class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Início
            </a>
            <a href="/hackathon/view/pages/restaurantes.php" class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Restaurantes
            </a>
            <a href="/hackathon/view/pages/roteiro.php" class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Roteiros
            </a>

            <?php if ($isAdmin): ?>
                <a href="/hackathon/view/admin/cadastrar_restaurante.php" 
                   class="block text-emerald-600 font-bold hover:pl-2 transition-all">
                   + Cadastrar Restaurante
                </a>
            <?php endif; ?>

            <hr class="border-slate-100">

            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="/hackathon/Controller/sairController.php" class="block text-red-600 font-medium hover:pl-2 transition-all">
                    Sair da conta
                </a>
            <?php else: ?>
                <a href="/hackathon/view/pages/login.php" class="block text-[#004e64] font-bold hover:pl-2 transition-all">
                    Entrar na conta
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>