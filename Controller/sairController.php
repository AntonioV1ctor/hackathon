<?php
require_once __DIR__ . "/../Services/sessaoService.php";

SessaoService::destruirSessao();
header('Location: /hackathon/index.php');
exit;
