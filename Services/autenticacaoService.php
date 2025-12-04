<?php
require_once __DIR__ . '/sessaoService.php';

class AutenticacaoService
{
    public static function validarAcessoSemLogin()
    {
        if (SessaoService::usuarioEstaLogado()) {
            header("Location: /hackathon/index.php");
            exit;
        }
    }

    public static function validarAcessoComLogin()
    {
        if (!SessaoService::usuarioEstaLogado()) {
            header("Location: /hackathon/View/pages/login.php");
            exit;
        }
    }

    public static function validarAcessoAdmin()
    {
        if (!SessaoService::usuarioEhAdmin()) {
            header("Location: /hackathon/index.php");
            exit;
        }
    }
}