<?php
require_once __DIR__ . '/sessaoService.php';

class AutenticacaoService
{
    /**
     * Valida se o usuário NÃO está logado. Se estiver, redireciona para a home.
     * Usado em páginas como Login e Cadastro.
     */
    public static function validarAcessoSemLogin()
    {
        if (SessaoService::usuarioEstaLogado()) {
            header("Location: /hackathon/index.php");
            exit;
        }
    }

    /**
     * Valida se o usuário ESTÁ logado. Se não estiver, redireciona para o login.
     * Usado em páginas restritas.
     */
    public static function validarAcessoComLogin()
    {
        if (!SessaoService::usuarioEstaLogado()) {
            header("Location: /hackathon/View/pages/login.php");
            exit;
        }
    }

    /**
     * Valida se o usuário é Administrador. Se não for, redireciona para a home.
     * Usado em páginas administrativas.
     */
    public static function validarAcessoAdmin()
    {
        if (!SessaoService::usuarioEhAdmin()) {
            header("Location: /hackathon/index.php");
            exit;
        }
    }
}