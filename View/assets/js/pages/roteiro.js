document.getElementById("buscaCidade").addEventListener("input", function () {
    let filtro = this.value.toLowerCase();
    document.querySelectorAll("#listaCidades label").forEach(l => {
        l.style.display = l.textContent.toLowerCase().includes(filtro) ? "flex" : "none";
    });
});

document.querySelectorAll("input[name='cidades[]']").forEach(chk => {
    chk.addEventListener("change", atualizarRefeicoes);
});

function atualizarRefeicoes() {
    const cont = document.getElementById("refeicoesContainer");
    cont.innerHTML = "";

    const selecionadas = [...document.querySelectorAll("input[name='cidades[]']:checked")]
        .map(e => e.value);

    selecionadas.forEach(cidade => {
        cont.innerHTML += `
                <div class="bg-slate-50 border rounded p-4 mb-3">
                    <p class="font-semibold text-[#004e64] mb-2">${cidade}</p>

                    <label class="flex gap-2 text-sm">
                        <input type="checkbox" name="refeicoes[${cidade}][]" value="cafe"> Café da manhã
                    </label>

                    <label class="flex gap-2 text-sm">
                        <input type="checkbox" name="refeicoes[${cidade}][]" value="almoco"> Almoço
                    </label>

                    <label class="flex gap-2 text-sm">
                        <input type="checkbox" name="refeicoes[${cidade}][]" value="jantar"> Jantar
                    </label>
                </div>`;
    });
}
