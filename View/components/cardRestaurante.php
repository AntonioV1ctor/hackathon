<?php

/**
 * cardRestaurante
 *
 * @param string $img      URL da imagem
 * @param string $nome     Nome do restaurante
 * @param string $cidade   Cidade
 * @param string $culinaria Tipo de culinária
 * @param int    $rating   Nota (1–5)
 * @param int    $preco    1=R$, 2=R$$, 3=R$$$
 * @param string $desc     Descrição
 * @param int|string $id   ID do restaurante
 * @param bool   $visitado Se o restaurante foi visitado
 *
 * @return string
 */
function cardRestaurante($img, $nome, $cidade, $culinaria, $rating, $preco, $desc, $id, $visitado = false)
{
    // Monta estrelas
    $starsFilled = str_repeat("★", $rating);
    $starsEmpty = str_repeat("☆", 5 - $rating);

    // Tratamento para preço (garantir int)
    if (is_string($preco)) {
        $preco = strtolower($preco);
        if ($preco === 'barato')
            $preco = 1;
        elseif ($preco === 'moderado')
            $preco = 2;
        elseif ($preco === 'caro')
            $preco = 3;
        elseif ($preco === 'sofisticado')
            $preco = 4;
        else
            $preco = (int) $preco; // Tenta converter numérico
    }
    // Garante range 1-4
    $preco = max(1, min(4, (int) $preco));

    $priceLabel = str_repeat("$", $preco);

    $checked = $visitado ? 'checked' : '';
    $tooltip = $visitado ? 'Marcar como não visitado' : 'Marcar como visitado';

    return "
    <article class='bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden relative group'>
        
        <div class=\"h-48 w-full bg-cover bg-center\" style=\"background-image:url('$img')\">
            <div class='absolute top-2 right-2'>
                <label class='cursor-pointer flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-md border-2 border-gray-200 hover:border-[#00a6bf] transition-all duration-200 check-label' title='$tooltip'>
                    <input type='checkbox' class='hidden toggle-visita' data-id='$id' $checked>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-gray-300 check-icon transition-colors duration-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M5 13l4 4L19 7' />
                    </svg>
                </label>
            </div>
        </div>

        <div class='p-4 flex flex-col justify-between h-48'>

            <div>
                <h3 class='text-lg font-semibold text-[#004e64]'>$nome</h3>
                <p class='text-sm text-slate-500'>$cidade • $culinaria</p>
            </div>

            <p class='text-sm text-slate-600 mt-2 line-clamp-2'>$desc</p>

            <div class='flex items-center justify-between mt-3'>
                <a href='/hackathon/View/pages/detalhesRestaurante.php?id=$id' 
                   class='text-sm font-semibold text-[#00a6bf] hover:underline'>
                    Detalhes →
                </a>

                <span class='text-sm font-bold text-[#1b7f5f]'>$priceLabel</span>
            </div>

        </div>
        <style>
            .toggle-visita:checked + .check-icon {
                color: #10b981; /* Emerald 500 */
                stroke: #10b981;
            }
            .toggle-visita:checked ~ .check-label {
                border-color: #10b981;
            }
            /* Custom style to fill the circle when checked if desired, but user asked for 'check' visibility. 
               Let's try making the icon green and bold first. 
               Actually, let's make the background green and icon white when checked for maximum visibility.
            */
            .check-label:has(.toggle-visita:checked) {
                background-color: #10b981;
                border-color: #10b981;
            }
            .check-label:has(.toggle-visita:checked) .check-icon {
                color: white;
                stroke: white;
            }
        </style>
        <script>
            // Ensure script only runs once per page load if multiple cards are present
            if (!window.toggleVisitaScriptLoaded) {
                window.toggleVisitaScriptLoaded = true;
                document.addEventListener('change', async function(e) {
                    if (e.target.classList.contains('toggle-visita')) {
                        const checkbox = e.target;
                        const id = checkbox.dataset.id;
                        const acao = checkbox.checked ? 'adicionar' : 'remover';
                        
                        try {
                            const response = await fetch('/hackathon/Controller/toggleVisitaController.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ restaurante_id: id, acao: acao })
                            });
                            
                            const data = await response.json();
                            if (!data.success) {
                                alert(data.message || 'Erro ao atualizar status');
                                checkbox.checked = !checkbox.checked; // Revert change
                            }
                        } catch (error) {
                            console.error('Erro:', error);
                            alert('Erro de conexão');
                            checkbox.checked = !checkbox.checked; // Revert change
                        }
                    }
                });
            }
        </script>
    </article>
    ";
}
