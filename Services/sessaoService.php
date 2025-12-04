<?php

class SessaoService
{
    const TEMPO_EXPIRACAO = 7200; // 2 * 60 * 60
    const TEMPO_RENOVACAO = 1800; // 30 * 60
    public static function iniciarSessao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function definirSessaoUsuario($usuario)
    {
        self::iniciarSessao();

        $_SESSION['id'] = $usuario->id;
        $_SESSION['tipo'] = $usuario->tipo;
        $_SESSION['email'] = $usuario->email;
        $_SESSION['usuario'] = $usuario->email;
        $_SESSION['foto_perfil'] = $usuario->foto_perfil ?? null;
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        $_SESSION['expires_at'] = time() + self::TEMPO_EXPIRACAO;
    }

    public static function verificarSessaoValida()
    {
        self::iniciarSessao();

        if (!isset($_SESSION['id']) || !isset($_SESSION['expires_at'])) {
            return false;
        }

        $agora = time();

        if ($agora > $_SESSION['expires_at']) {
            self::destruirSessao();
            return false;
        }

        if (($agora - $_SESSION['last_activity']) > self::TEMPO_RENOVACAO) {
            self::renovarSessao();
        }

        $_SESSION['last_activity'] = $agora;

        return true;
    }

    public static function renovarSessao()
    {
        if (isset($_SESSION['id'])) {
            $_SESSION['expires_at'] = time() + self::TEMPO_EXPIRACAO;
            $_SESSION['last_activity'] = time();
        }
    }

    public static function usuarioEstaLogado()
    {
        return self::verificarSessaoValida();
    }

    public static function obterDadosUsuario()
    {
        if (!self::verificarSessaoValida()) {
            return null;
        }

        return [
            'id' => $_SESSION['id'],
            'tipo' => $_SESSION['tipo'],
            'email' => $_SESSION['email'],
            'usuario' => $_SESSION['usuario'],
            'foto_perfil' => $_SESSION['foto_perfil'] ?? null,
            'login_time' => $_SESSION['login_time'],
            'expires_at' => $_SESSION['expires_at'],
            'last_activity' => $_SESSION['last_activity']
        ];
    }

    public static function usuarioEhAdmin()
    {
        $dados = self::obterDadosUsuario();
        return $dados && $dados['tipo'] === 'admin';
    }

    public static function destruirSessao()
    {
        self::iniciarSessao();

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public static function obterTempoRestante()
    {
        if (!isset($_SESSION['expires_at'])) {
            return 0;
        }

        $restante = $_SESSION['expires_at'] - time();
        return max(0, $restante);
    }

    public static function obterInfoSessao()
    {
        if (!self::verificarSessaoValida()) {
            return null;
        }

        $agora = time();

        return [
            'usuario_id' => $_SESSION['id'],
            'tipo_usuario' => $_SESSION['tipo'],
            'email' => $_SESSION['email'],
            'foto_perfil' => $_SESSION['foto_perfil'] ?? null,
            'login_time' => date('Y-m-d H:i:s', $_SESSION['login_time']),
            'last_activity' => date('Y-m-d H:i:s', $_SESSION['last_activity']),
            'expires_at' => date('Y-m-d H:i:s', $_SESSION['expires_at']),
            'tempo_restante_segundos' => self::obterTempoRestante(),
            'tempo_restante_minutos' => round(self::obterTempoRestante() / 60),
            'tempo_restante_horas' => round(self::obterTempoRestante() / 3600, 1),
            'expira_em' => self::obterTempoRestante() > 3600 ?
                round(self::obterTempoRestante() / 3600, 1) . ' horas' :
                round(self::obterTempoRestante() / 60) . ' minutos'
        ];
    }
}