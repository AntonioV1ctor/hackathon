<?php

/**
 * cardEvento
 *
 * @param string $img       Imagem do evento
 * @param string $titulo    Título do evento
 * @param string $cidade    Local/cidade
 * @param string $data      Data do evento
 * @param string $desc      Descrição curta
 * @param int|string $id    ID do evento
 *
 * @return string
 */
function cardEvento($img, $titulo, $cidade, $data, $desc, $id)
{
    return "
    <article class='bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden'>

        <div class=\"h-48 w-full bg-cover bg-center\" style=\"background-image:url('$img')\"></div>

        <div class='p-4 flex flex-col justify-between h-48'>

            <div>
                <h3 class='text-lg font-semibold text-[#004e64]'>$titulo</h3>
                <p class='text-sm text-slate-500'>$cidade • $data</p>
            </div>

            <p class='text-sm text-slate-600 mt-2 line-clamp-2'>$desc</p>

            <div class='flex justify-end mt-3'>
                <a href='/evento.php?id=$id'
                   class='text-sm font-semibold text-[#00a6bf] hover:underline'>
                    Ver evento →
                </a>
            </div>

        </div>
    </article>
    ";
}
