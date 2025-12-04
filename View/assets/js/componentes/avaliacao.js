document.addEventListener("DOMContentLoaded", () => {

    const stars = document.querySelectorAll("#ratingStars .star");
    const ratingInput = document.getElementById("userRating");
    let currentRating = 0;

    function atualizarEstrelas(valor) {
        stars.forEach(star => {
            const n = star.getAttribute("data-star");
            star.classList.toggle("text-yellow-400", n <= valor);
            star.classList.toggle("text-slate-300", n > valor);
        });
    }

    // Hover pré-visualização
    stars.forEach(star => {
        star.addEventListener("mouseenter", () => {
            const valor = star.getAttribute("data-star");
            atualizarEstrelas(valor);
        });
    });

    // Sai do hover → volta para o valor salvo
    document.getElementById("ratingStars").addEventListener("mouseleave", () => {
        atualizarEstrelas(currentRating);
    });

    // Clique → salva a avaliação
    stars.forEach(star => {
        star.addEventListener("click", () => {
            currentRating = star.getAttribute("data-star");
            ratingInput.value = currentRating;
            atualizarEstrelas(currentRating);
        });
    });

});
