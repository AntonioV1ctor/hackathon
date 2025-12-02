const btn = document.getElementById('mobile-btn');
const menu = document.getElementById('mobile-menu');
const iconOpen = document.getElementById('icon-open');
const iconClose = document.getElementById('icon-close');

btn.addEventListener('click', () => {
    // Alterna a visibilidade do menu
    menu.classList.toggle('hidden');

    // Alterna os ícones (Hamburguer <-> X)
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
});
