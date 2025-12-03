<?php

class AutenticacaoService
{
    public static function validarAcessoSemLogin()
    {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['id']) && !empty($_SESSION['perfil'])) {
            header("Location: /hackathon/index.php");
            exit;
        }
    }
}