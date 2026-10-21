<?php
declare(strict_types=1);
require dirname(__DIR__,2) . '/app/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/admin/');
verify_csrf(); $_SESSION = []; session_destroy(); redirect('/admin/login.php');
