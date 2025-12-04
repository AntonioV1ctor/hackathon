<?php
require_once __DIR__ . '/../../Services/sessaoService.php';

$usuarioLogado = SessaoService::usuarioEstaLogado();
$isAdmin = SessaoService::usuarioEhAdmin();
$infoSessao = $usuarioLogado ? SessaoService::obterInfoSessao() : null;
?>

<header class="bg-white/95 backdrop-blur sticky top-0 z-[1000] shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 relative flex items-center justify-between">

        <a href="/hackathon/index.php" class="flex items-center gap-3 group">
            <img src="https://img.icons8.com/fluency/48/restaurant.png"
                class="h-9 w-9 transform group-hover:scale-105 transition" alt="Logo">

            <div>
                <h1 class="text-lg font-bold text-[#004e64] group-hover:text-[#007889] transition">
                    Sabores do Turismo
                </h1>
                <p class="text-xs text-[#6b7280]">Turismo gastronômico • Mato Grosso do Sul</p>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-[#6b7280]">
            <a href="/hackathon" class="hover:text-[#00a6bf] transition">Início</a>
            <a href="/hackathon/View/pages/restaurantes.php" class="hover:text-[#00a6bf] transition">Restaurantes</a>
            <a href="/hackathon/View/pages/roteiro.php" class="hover:text-[#00a6bf] transition">Roteiros</a>
            <a href="/hackathon/View/pages/mapa.php" class="hover:text-[#00a6bf] transition">Mapa</a>

            <?php if ($isAdmin): ?>
                <a href="/hackathon/View/pages/administracao.php"
                    class="text-emerald-600 font-bold hover:text-emerald-700 transition flex items-center gap-1">
                    Administração
                </a>
            <?php endif; ?>

            <?php if ($usuarioLogado): ?>
                <div class="flex items-center gap-3">
                    <a href="/hackathon/Controller/sairController.php"
                        class="px-4 py-2 rounded-md border border-[#004e64] text-[#004e64] hover:bg-slate-50 transition shadow">
                        Sair
                    </a>
                </div>
            <?php else: ?>
                <a href="/hackathon/View/pages/login.php"
                    class="px-4 py-2 rounded-md bg-[#004e64] text-white hover:bg-[#003947] transition shadow">
                    Entrar
                </a>
            <?php endif; ?>
        </nav>

        <button id="mobile-btn" class="md:hidden p-2 text-[#004e64] focus:outline-none">
            <svg id="icon-open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
            <svg id="icon-close" class="hidden w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

    </div>

    <div id="mobile-menu"
        class="hidden md:hidden absolute top-full left-0 w-full bg-white border-t border-slate-200 shadow-xl z-[999]">
        <nav class="flex flex-col p-4 space-y-3 font-medium text-[#6b7280]">
            <a href="/hackathon" class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Início
            </a>
            <a href="/hackathon/View/pages/restaurantes.php"
                class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Restaurantes
            </a>
            <a href="/hackathon/View/pages/roteiro.php" class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Roteiros
            </a>
            <a href="/hackathon/View/pages/mapa.php" class="block hover:text-[#00a6bf] hover:pl-2 transition-all">
                Mapa
            </a>

            <?php if ($isAdmin): ?>
                <a href="/hackathon/View/pages/administracao.php"
                    class="block text-emerald-600 font-bold hover:pl-2 transition-all">
                    Administração
                </a>
            <?php endif; ?>

            <hr class="border-slate-100">

            <?php if ($usuarioLogado): ?>
                <div class="border-t border-slate-100 pt-3">
                    <div class="text-xs text-slate-400 mb-2 px-4">
                        Sessão expira em <?php echo $infoSessao['expira_em']; ?>
                    </div>
                    <a href="/hackathon/Controller/sairController.php"
                        class="block text-red-600 font-medium hover:pl-2 transition-all px-4">
                        Sair da conta
                    </a>
                </div>
            <?php else: ?>
                <a href="/hackathon/View/pages/login.php" class="block text-[#004e64] font-bold hover:pl-2 transition-all">
                    Entrar na conta
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>