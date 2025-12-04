<?php

/**
 * Arquivo de inicialização da aplicação
 * Deve ser incluído no início de todas as páginas que precisam verificar autenticação
 */

require_once __DIR__ . '/Services/sessaoService.php';
require_once __DIR__ . '/Services/autenticacaoService.php';

SessaoService::iniciarSessao();


if (isset($_SESSION['id']) && !SessaoService::verificarSessaoValida()) {
    $_SESSION['erro'] = 'Sua sessão expirou. Faça login novamente.';
    SessaoService::destruirSessao();
    header("Location: /hackathon/View/pages/login.php");
    exit;
}