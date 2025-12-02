
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("loginForm");
    if (!form) return; // impede erro se rodar em outra página

    const alertBox = document.getElementById("alert");

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        fetch('/hackathon/Controller/loginController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, senha: password })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertBox.classList.add("hidden");
                    window.location.href = "/hackathon/index.php";
                } else {
                    alertBox.textContent = data.message;
                    alertBox.classList.remove("hidden");
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alertBox.textContent = "Erro ao conectar com o servidor.";
                alertBox.classList.remove("hidden");
            });
    });

});
