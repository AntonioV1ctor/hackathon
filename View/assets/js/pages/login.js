
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("loginForm");
    if (!form) return; // impede erro se rodar em outra página

    const alertBox = document.getElementById("alert");

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        if (email === "admin@ms.com" && password === "1234") {
            alertBox.classList.add("hidden");
            window.location.href = "/hackathon/index.php";
        } else {
            alertBox.textContent = "E-mail ou senha incorretos.";
            alertBox.classList.remove("hidden");
        }
    });

});
