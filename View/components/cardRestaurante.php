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
 *
 * @return string
 */
function cardRestaurante($img, $nome, $cidade, $culinaria, $rating, $preco, $desc, $id)
{
    // Monta estrelas
    $starsFilled = str_repeat("★", $rating);
    $starsEmpty  = str_repeat("☆", 5 - $rating);

    // Preço como R$, R$$, R$$$
    $priceLabel = str_repeat("R$", $preco);

    return "
    <article class='bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden'>
        
        <div class=\"h-48 w-full bg-cover bg-center\" style=\"background-image:url('$img')\"></div>

        <div class='p-4 flex flex-col justify-between h-48'>

            <div>
                <h3 class='text-lg font-semibold text-[#004e64]'>$nome</h3>
                <p class='text-sm text-slate-500'>$cidade • $culinaria</p>

                <div class='mt-2 text-[#f2c14e] text-sm'>
                    $starsFilled$starsEmpty
                </div>
            </div>

            <p class='text-sm text-slate-600 mt-2 line-clamp-2'>$desc</p>

            <div class='flex items-center justify-between mt-3'>
                <a href='/restaurante.php?id=$id' 
                   class='text-sm font-semibold text-[#00a6bf] hover:underline'>
                    Detalhes →
                </a>

                <span class='text-sm font-bold text-[#1b7f5f]'>$priceLabel</span>
            </div>

        </div>
    </article>
    ";
}
