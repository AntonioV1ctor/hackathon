<?php
require_once '../../init.php';
require_once '../components/head.php';
require_once '../../Model/usuarioModel.php';

if (!isset($_SESSION['id'])) {
    header('Location: /hackathon/View/pages/login.php');
    exit();
}

$usuarioModel = new UsuarioModel();
$usuario = $usuarioModel->findUsuarioById($_SESSION['id']);
if (!$usuario) {
    echo "Erro ao carregar dados do usuário.";
    exit();
}
?>

<body class="bg-gradient-to-b from-[#e4f1f4] to-white text-slate-900 min-h-screen flex flex-col">

    <?php require_once '../components/navbar.php'; ?>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0 bg-[#004e64] md:w-48 flex items-center justify-center">
                    <div
                        class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-[#004e64] text-4xl font-bold uppercase">
                        <?php echo substr($usuario['nome'], 0, 1); ?>
                    </div>
                </div>
                <div class="p-8 w-full">
                    <div class="uppercase tracking-wide text-sm text-[#00a6bf] font-semibold">Meu Perfil</div>
                    <h1 class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">
                        <?php echo htmlspecialchars($usuario['nome']); ?>
                    </h1>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo htmlspecialchars($usuario['email']); ?>
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Tipo de Usuário</dt>
                                <dd class="mt-1 text-sm text-gray-900 capitalize">
                                    <?php echo htmlspecialchars($usuario['tipo']); ?>
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Membro desde</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php echo isset($usuario['criado_em']) ? date('d/m/Y', strtotime($usuario['criado_em'])) : 'N/A'; ?>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <a href="/hackathon/Controller/sairController.php"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Sair
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../components/footer.php'; ?>

</body>

</html>