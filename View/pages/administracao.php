<?php 
require_once '../components/head.php'; 

// Mock data (same as restaurants.php for consistency)
$restaurantes = [
    [
        "id" => 1,
        "nome" => "Casa do João",
        "cidade" => "Bonito",
        "culinaria" => "Pantaneira",
        "preco" => 2,
        "rating" => 5,
        "img" => "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&w=900",
        "desc" => "Pratos típicos regionais."
    ],
    [
        "id" => 2,
        "nome" => "Tayama Sushi",
        "cidade" => "Campo Grande",
        "culinaria" => "Japonês",
        "preco" => 3,
        "rating" => 4,
        "img" => "https://images.unsplash.com/photo-1555992336-cbfcd98a6e56?auto=format&w=900",
        "desc" => "Sushi com toque regional."
    ],
];
?>

<body class="bg-slate-100 font-sans">

    <?php require_once '../components/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-10 min-h-[calc(100vh-200px)]">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#004e64]">Administração</h1>
                <p class="text-slate-500">Gerencie os restaurantes cadastrados no sistema.</p>
            </div>
            
            <a href="/hackathon/View/pages/cadastrarRestaurante.php" 
               class="bg-[#004e64] hover:bg-[#003947] text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                <span>+</span> Adicionar Restaurante
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Restaurante</th>
                            <th class="px-6 py-4">Cidade</th>
                            <th class="px-6 py-4">Culinária</th>
                            <th class="px-6 py-4">Preço</th>
                            <th class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($restaurantes)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    Nenhum restaurante cadastrado.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($restaurantes as $r): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-400">#<?= $r['id'] ?></td>
                                    <td class="px-6 py-4 font-medium text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <img src="<?= $r['img'] ?>" alt="" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                            <span><?= $r['nome'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4"><?= $r['cidade'] ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full bg-slate-100 text-xs font-medium text-slate-600">
                                            <?= $r['culinaria'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-emerald-600 font-medium">
                                        <?= str_repeat('$', $r['preco']) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="/hackathon/View/pages/cadastrarRestaurante.php?id=<?= $r['id'] ?>" 
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded transition" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button onclick="confirmDelete(<?= $r['id'] ?>)" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded transition" title="Excluir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Mock -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                <span class="text-sm text-slate-500">Mostrando <?= count($restaurantes) ?> resultados</span>
                <div class="flex gap-1">
                    <button class="px-3 py-1 rounded border border-slate-300 bg-white text-slate-500 text-sm disabled:opacity-50" disabled>Anterior</button>
                    <button class="px-3 py-1 rounded border border-slate-300 bg-white text-slate-500 text-sm disabled:opacity-50" disabled>Próxima</button>
                </div>
            </div>
        </div>

    </main>

    <?php require_once '../components/footer.php'; ?>

    <script>
        function confirmDelete(id) {
            if (confirm('Tem certeza que deseja excluir este restaurante?')) {
                // Aqui entraria a lógica de exclusão (AJAX ou redirect)
                alert('Simulação: Restaurante ' + id + ' excluído!');
                // window.location.href = 'delete_restaurant.php?id=' + id;
            }
        }
    </script>

</body>
</html>
