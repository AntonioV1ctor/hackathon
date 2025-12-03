<?php require_once '../components/head.php' ?>

<body class="min-h-screen bg-[#f8fafc] flex">

    <!-- LADO ESQUERDO -->
    <div class="hidden lg:flex w-1/2 relative">
        <img 
            src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=60"
            alt="Culinária do MS"
            class="object-cover w-full h-full"
        >

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <div class="absolute inset-0 flex items-center justify-center text-center px-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white drop-shadow">Crie sua conta</h1>
                <p class="mt-4 text-lg text-white/90 drop-shadow">
                    Acesse recursos exclusivos do portal gastronômico.
                </p>
            </div>
        </div>
    </div>

    <!-- CARD CADASTRO -->
    <div class="flex w-full lg:w-1/2 items-center justify-center px-6 py-10 bg-white">

        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-slate-200">

            <div class="flex flex-col items-center mb-6">
                <div class="h-14 w-14 rounded-full bg-[#004e64] flex items-center justify-center shadow-md">
                    <img src="https://img.icons8.com/fluency/48/restaurant.png" class="h-9 w-9">
                </div>

                <h1 class="text-2xl font-bold text-[#004e64] mt-3">
                    Criar Conta de Usuário
                </h1>
                <p class="text-sm text-[#6b7280]">É rápido e gratuito</p>
            </div>

            <?php
            if (isset($_SESSION['message'])) {
                $type = $_SESSION['type'] ?? 'erro';
                $colorClass = $type === 'sucesso' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                echo "<div id='alert' class='mb-4 p-3 rounded $colorClass text-sm'>{$_SESSION['message']}</div>";
                unset($_SESSION['message']);
                unset($_SESSION['type']);
            } else {
                echo '<div id="alert" class="hidden mb-4 p-3 rounded bg-red-100 text-red-700 text-sm"></div>';
            }
            ?>

            <form id="cadForm" action="../../Controller/cadastroController.php" method="POST" class="space-y-4">

                <div>
                    <label class="text-sm font-medium text-[#004e64]">Nome completo</label>
                    <input 
                        id="nome"
                        name="nome"
                        type="text"
                        required
                        placeholder="Seu nome"
                        class="w-full mt-1 p-2 border rounded bg-white 
                               focus:ring-2 focus:ring-[#00a6bf]"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium text-[#004e64]">E-mail</label>
                    <input 
                        id="email"
                        name="email"
                        type="email"
                        required
                        placeholder="email@exemplo.com"
                        class="w-full mt-1 p-2 border rounded bg-white 
                               focus:ring-2 focus:ring-[#00a6bf]"
                    >
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-[#004e64]">Senha</label>
                        <input 
                            id="senha"
                            name="senha"
                            type="password"
                            required
                            minlength="4"
                            placeholder="••••••••"
                            class="w-full mt-1 p-2 border rounded bg-white 
                                   focus:ring-2 focus:ring-[#00a6bf]"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium text-[#004e64]">Confirmar senha</label>
                        <input 
                            id="confirmar"
                            name="confirmar"
                            type="password"
                            required
                            minlength="4"
                            placeholder="••••••••"
                            class="w-full mt-1 p-2 border rounded bg-white 
                                   focus:ring-2 focus:ring-[#00a6bf]"
                        >
                    </div>
                </div>

                <button 
                    type="submit"
                    class="w-full py-2 bg-[#004e64] text-white rounded-md font-semibold 
                           hover:bg-[#003947] transition 
                           focus:ring-2 focus:ring-[#00a6bf]"
                >
                    Criar conta
                </button>

            </form>

            <p class="text-center text-sm text-[#6b7280] mt-4">
                Já tem conta?
                <a href="login.php" class="text-[#00a6bf] font-medium hover:underline">
                    Fazer login
                </a>
            </p>

        </div>
    </div>
