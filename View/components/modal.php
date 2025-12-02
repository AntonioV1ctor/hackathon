<div id="modal-root" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative max-w-3xl w-full bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between">
            <h4 id="modal-title" class="text-xl font-bold text-[#004e64]"></h4>
            <button id="modal-close"
                class="px-3 py-1 bg-slate-100 rounded hover:bg-slate-200">Fechar</button>
        </div>

        <p id="modal-sub" class="text-sm text-[#6b7280] mt-1"></p>

        <div id="modal-gallery" class="h-52 rounded mt-4 bg-cover bg-center"></div>

        <p id="modal-desc" class="mt-4 text-sm text-[#6b7280]"></p>

        <p class="text-sm mt-2"><strong>Horário:</strong> <span id="modal-hours"></span></p>
        <p class="text-sm"><strong>Endereço:</strong> <span id="modal-address"></span></p>

        <a id="modal-action"
           class="inline-block mt-4 px-4 py-2 bg-[#00a6bf] rounded font-semibold" href="#">
            Ver restaurante
        </a>
    </div>
</div>
