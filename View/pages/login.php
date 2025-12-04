<?php
require_once '../components/head.php';
require_once '../../Model/loginModel.php';

$mostrarSeguranca = false;
$perguntaSeguranca = '';

if (isset($_SESSION['login_temp_email'])) {
    $loginModel = new LoginModel();
    $perguntaSeguranca = $loginModel->buscarPerguntaSeguranca($_SESSION['login_temp_email']);
    if ($perguntaSeguranca) {
        $mostrarSeguranca = true;
    }
}
?>

<body class="min-h-screen bg-[#f8fafc] flex">

    <!-- LADO ESQUERDO COM IMAGEM -->
    <div class="hidden lg:flex w-1/2 relative">
        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=60"
            alt="Prato regional MS" class="object-cover w-full h-full">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <div class="absolute inset-0 flex items-center justify-center text-center px-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white drop-shadow">
                    Gastronomia MS
                </h1>
                <p class="mt-4 text-lg text-white/90 drop-shadow">
                    Sabores do Pantanal e do Cerrado em um só lugar.
                </p>
            </div>
        </div>
    </div>

    <!-- CARD DE LOGIN -->
    <div class="flex w-full lg:w-1/2 items-center justify-center px-6 py-10 bg-white">

        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-slate-200">

            <div class="flex flex-col items-center mb-6">
                <div class="h-14 w-14 rounded-full bg-[#004e64] flex items-center justify-center shadow-md">
                    <img src="https://img.icons8.com/fluency/48/restaurant.png" class="h-9 w-9">
                </div>

                <h1 class="text-2xl font-bold text-[#004e64] mt-3">
                    <?php echo $mostrarSeguranca ? 'Verificação de Segurança' : 'Portal Administrativo'; ?>
                </h1>
                <p class="text-sm text-[#6b7280]">
                    <?php echo $mostrarSeguranca ? 'Responda sua pergunta de segurança' : 'Acesse sua área de gestão'; ?>
                </p>
            </div>

            <?php
            if (isset($_SESSION['erro'])) {
                echo "<div id='alert' class='mb-4 p-3 rounded bg-red-100 text-red-700 text-sm'>{$_SESSION['erro']}</div>";
                unset($_SESSION['erro']);
            } else {
                echo '<div id="alert" class="hidden mb-4 p-3 rounded bg-red-100 text-red-700 text-sm"></div>';
            }
            ?>

            <?php if ($mostrarSeguranca): ?>
                <form id="segurancaForm" action="../../Controller/loginController.php" method="POST" class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-[#004e64]">Pergunta de Segurança</label>
                        <div class="mt-1 p-3 border rounded bg-gray-50 text-sm text-[#6b7280]">
                            <?php echo htmlspecialchars($perguntaSeguranca); ?>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-[#004e64]">Resposta</label>
                        <input id="resposta_seguranca" name="resposta_seguranca" type="text" required
                            placeholder="Sua resposta" class="w-full mt-1 p-2 border rounded bg-white 
                                   focus:ring-2 focus:ring-[#00a6bf]">
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#004e64] text-white rounded-md font-semibold 
                               hover:bg-[#003947] transition 
                               focus:ring-2 focus:ring-[#00a6bf]">
                        Verificar
                    </button>
                </form>
            <?php else: ?>
                <form id="loginForm" action="../../Controller/loginController.php" method="POST" class="space-y-4">

                    <div>
                        <label class="text-sm font-medium text-[#004e64]">E-mail</label>
                        <input id="email" name="email" type="email" required placeholder="email@exemplo.com" class="w-full mt-1 p-2 border rounded bg-white 
                                   focus:ring-2 focus:ring-[#00a6bf]">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-[#004e64]">Senha</label>
                        <input id="password" name="senha" type="password" required minlength="4" placeholder="••••••••"
                            class="w-full mt-1 p-2 border rounded bg-white 
                                   focus:ring-2 focus:ring-[#00a6bf]">
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#004e64] text-white rounded-md font-semibold 
                               hover:bg-[#003947] transition 
                               focus:ring-2 focus:ring-[#00a6bf]">
                        Entrar
                    </button>

                </form>
            <?php endif; ?>

            <p class="text-center text-sm text-[#6b7280] mt-4">
                Não tem conta?
                <a href="cadastro.php" class="text-[#00a6bf] font-medium hover:underline">
                    Criar conta
                </a>
            </p>
        </div>
    </div>


</body>

</html>