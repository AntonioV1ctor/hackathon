<?php
require_once __DIR__ . "/../Services/sessaoService.php";
require_once __DIR__ . "/../Model/loginModel.php";

SessaoService::iniciarSessao();

try {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método inválido para esta requisição");
    }

    if (isset($_POST['resposta_seguranca'])) {
        $email = $_SESSION['login_temp_email'] ?? '';
        $respostaSeguranca = trim($_POST['resposta_seguranca'] ?? '');

        if (empty($email) || empty($respostaSeguranca)) {
            unset($_SESSION['login_temp_email']);
            throw new Exception("Sessão expirada. Faça login novamente.");
        }

        $loginModel = new LoginModel();

        if (!$loginModel->verificarRespostaSeguranca($email, $respostaSeguranca)) {
            $_SESSION['loginTentativasSeguranca'] = ($_SESSION['loginTentativasSeguranca'] ?? 0) + 1;

            if ($_SESSION['loginTentativasSeguranca'] >= 3) {
                unset($_SESSION['login_temp_email']);
                unset($_SESSION['login_temp_usuario']);
                unset($_SESSION['loginTentativasSeguranca']);
                throw new Exception("Muitas tentativas. Faça login novamente.");
            }

            throw new Exception("Resposta de segurança incorreta.");
        }

        $usuarioLogin = $_SESSION['login_temp_usuario'];

        SessaoService::definirSessaoUsuario($usuarioLogin);

        unset($_SESSION['login_temp_email']);
        unset($_SESSION['login_temp_usuario']);
        unset($_SESSION['loginTentativas']);
        unset($_SESSION['loginTentativasSeguranca']);
        unset($_SESSION['loginBloqueado']);

        header('Location: /hackathon/index.php');
        exit();
    }

    if (isset($_SESSION['loginBloqueado']) && time() < $_SESSION['loginBloqueado']) {
        $restante = $_SESSION['loginBloqueado'] - time();
        throw new Exception("Muitas tentativas de login. Tente novamente em alguns segundos.");
    }

    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        throw new Exception("Preencha todos os campos");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Informe um email válido");
    }

    $loginModel = new LoginModel();
    $usuarioLogin = $loginModel->login($email, $senha);

    if (!$usuarioLogin) {
        $_SESSION['loginTentativas'] = ($_SESSION['loginTentativas'] ?? 0) + 1;

        if ($_SESSION['loginTentativas'] >= 5) {
            $_SESSION['loginBloqueado'] = time() + 120;
            $_SESSION['loginTentativas'] = 0;
            throw new Exception("Muitas tentativas de login. Aguarde 2 minutos.");
        }

        throw new Exception("Email ou senha incorretos.");
    } else {
        $_SESSION['login_temp_email'] = $email;
        $_SESSION['login_temp_usuario'] = $usuarioLogin;
        $_SESSION['loginTentativas'] = 0;
        unset($_SESSION['loginBloqueado']);

        header('Location: /hackathon/View/pages/login.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    header('Location: /hackathon/View/pages/login.php');
    exit();
}
