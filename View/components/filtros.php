<form action="/hackathon/restaurantes.php" method="GET">

<section class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6">

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <div>
            <label class="text-sm font-medium text-slate-600 mb-1 flex gap-2 items-center">
                Buscar
            </label>
            <input name="q" id="search"
                class="p-2 px-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#00a6bf]"
                placeholder="Prato, nome...">
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 mb-1 flex gap-2 items-center">
                Cidade
            </label>
            <select name="cidade" id="filter-city"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]">
                <option value="">Todas</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 mb-1 flex gap-2 items-center">
                Culinária
            </label>
            <select name="culinaria" id="filter-cuisine"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]">
                <option value="">Todas</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 mb-1 flex gap-2 items-center">
                Preço
            </label>
            <select name="preco" id="filter-price"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]">
                <option value="">Todos</option>
                <option value="1">R$</option>
                <option value="2">R$$</option>
                <option value="3">R$$$</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600 mb-1 flex gap-2 items-center">
                Avaliação
            </label>
            <select name="rating" id="filter-rating"
                class="p-2 border rounded-lg shadow-sm w-full focus:ring-2 focus:ring-[#00a6bf]">
                <option value="">Todas</option>
                <option value="4">4 ★+</option>
                <option value="3">3 ★+</option>
                <option value="2">2 ★+</option>
            </select>
        </div>

    </div>

    <div class="flex justify-end mt-6 gap-3">
        <button type="submit"
            class="px-4 py-2 rounded-lg bg-[#00a6bf] text-white hover:bg-[#0090a4] transition font-semibold">
            Filtrar
        </button>

        <a href="/hackathon/lista.php"
            class="px-4 py-2 rounded-lg bg-[#004e64] text-white hover:bg-[#003947] transition font-semibold">
            Limpar
        </a>
    </div>

</section>

</form>
