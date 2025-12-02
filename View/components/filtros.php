<section class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6">

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <div>
            <label class="text-sm font-medium text-slate-600 flex gap-2 items-center mb-1">
                🔍 Buscar
            </label>
            <input id="search"
                class="p-2 px-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#00a6bf]"
                placeholder="Prato, nome...">
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 flex gap-2 items-center mb-1">
                📍 Cidade
            </label>
            <select id="filter-city"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]"></select>
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 flex gap-2 items-center mb-1">
                🍽️ Culinária
            </label>
            <select id="filter-cuisine"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]"></select>
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 flex gap-2 items-center mb-1">
                💵 Preço
            </label>
            <select id="filter-price"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]"></select>
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 flex gap-2 items-center mb-1">
                ⭐ Avaliação
            </label>
            <select id="filter-rating"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]"></select>
        </div>

    </div>

    <div class="flex justify-end mt-6">
        <button id="reset"
            class="px-4 py-2 rounded-lg bg-[#004e64] text-white hover:bg-[#003947] transition font-semibold">
            Limpar filtros
        </button>
    </div>
</section>
