<?php
session_start();
session_destroy();
header('Location: /hackathon/index.php');
exit;
