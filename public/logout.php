<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/');
verify_csrf();
unset($_SESSION['member_id'], $_SESSION['member_name'], $_SESSION['member_email']);
session_regenerate_id(true);
redirect('/');
