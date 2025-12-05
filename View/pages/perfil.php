<?php
require_once '../../init.php';
require_once '../components/head.php';
require_once '../../Model/usuarioModel.php';

if (!isset($_SESSION['id'])) {
    header('Location: /hackathon/View/pages/login.php');
    exit();
}

$usuarioModel = new UsuarioModel();
$usuario = $usuarioModel->buscarUsuarioPorId($_SESSION['id']);
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
                <div class="md:flex-shrink-0 bg-[#004e64] md:w-48 flex items-center justify-center overflow-hidden relative group cursor-pointer"
                    id="foto-container">
                    <?php if (!empty($usuario['foto_perfil'])): ?>
                        <img src="<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de Perfil"
                            class="h-full w-full object-cover" id="foto-img">
                    <?php else: ?>
                        <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-[#004e64] text-4xl font-bold uppercase"
                            id="foto-placeholder">
                            <?php echo substr($usuario['nome'], 0, 1); ?>
                        </div>
                        <img src="" alt="Foto de Perfil" class="h-full w-full object-cover hidden" id="foto-img-hidden">
                    <?php endif; ?>

                    <div
                        class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <span class="text-white font-medium text-sm flex flex-col items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Alterar foto
                        </span>
                    </div>
                    <input type="file" id="foto-input" class="hidden" accept="image/*">
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

                    <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Restaurantes Visitados</h2>
                        <?php
                        $restaurantesVisitados = $usuarioModel->listarRestaurantesVisitados($usuario['id']);
                        if (count($restaurantesVisitados) > 0):
                            ?>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200" id="tabela-visitados">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurante</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Endereço</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data da Visita</th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Ações</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($restaurantesVisitados as $visita): ?>
                                                    <tr id="visita-<?php echo $visita['id']; ?>">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            <?php echo htmlspecialchars($visita['nome']); ?>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            <?php echo htmlspecialchars($visita['endereco']); ?>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            <?php echo date('d/m/Y H:i', strtotime($visita['visitado_em'])); ?>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <button onclick="removerVisita(<?php echo $visita['id']; ?>)" class="text-red-600 hover:text-red-900" title="Remover dos visitados">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php else: ?>
                                <p class="text-gray-500 text-sm">Você ainda não marcou nenhum restaurante como visitado.</p>
                        <?php endif; ?>
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

    <script>
        document.getElementById('foto-container').addEventListener('click', function() {
            document.getElementById('foto-input').click();
        });

        document.getElementById('foto-input').addEventListener('change', async function() {
            if (this.files && this.files[0]) {
                const formData = new FormData();
                formData.append('foto_perfil', this.files[0]);

                try {
                    const response = await fetch('/hackathon/Controller/uploadFotoPerfilController.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update image on page
                        const img = document.getElementById('foto-img');
                        const imgHidden = document.getElementById('foto-img-hidden');
                        const placeholder = document.getElementById('foto-placeholder');

                        if (img) {
                            img.src = data.url;
                        } else {
                            // If was placeholder, hide it and show image
                            if (placeholder) placeholder.classList.add('hidden');
                            if (imgHidden) {
                                imgHidden.src = data.url;
                                imgHidden.classList.remove('hidden');
                                imgHidden.id = 'foto-img'; // Promote to main img
                            }
                        }
                    } else {
                        alert(data.message || 'Erro ao enviar foto.');
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro de conexão.');
                }
            }
        });

        async function removerVisita(id) {
            if (!confirm('Tem certeza que deseja remover este restaurante dos visitados?')) return;

            try {
                const response = await fetch('/hackathon/Controller/toggleVisitaController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ restaurante_id: id, acao: 'remover' })
                });
                
                const data = await response.json();
                if (data.success) {
                    const row = document.getElementById('visita-' + id);
                    if (row) {
                        row.remove();
                        // Check if table is empty
                        const tbody = document.querySelector('#tabela-visitados tbody');
                        if (tbody && tbody.children.length === 0) {
                            location.reload(); // Reload to show empty state message
                        }
                    }
                } else {
                    alert(data.message || 'Erro ao remover visita');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro de conexão');
            }
        }
    </script>

</body>

</html>