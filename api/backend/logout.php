<?php

declare(strict_types=1);

require_once __DIR__ . '/session_init.php';

$_SESSION = [];

header('Location: ../index.php');
exit();

?>