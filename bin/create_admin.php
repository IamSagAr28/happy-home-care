<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
$name=trim($argv[1]??readline('Admin name: ')); $email=strtolower(trim($argv[2]??readline('Admin email: ')));
if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)){fwrite(STDERR,"Usage: php bin/create_admin.php \"Admin name\" admin@example.com\n");exit(1);}
fwrite(STDOUT,'Password (min. 12 characters): '); if(function_exists('shell_exec')) @shell_exec('stty -echo'); $password=trim((string)fgets(STDIN)); if(function_exists('shell_exec')) @shell_exec('stty echo'); fwrite(STDOUT,"\n");
if(strlen($password)<12){fwrite(STDERR,"Use a password with at least 12 characters.\n");exit(1);}
$stmt=db()->prepare('INSERT INTO admins (name,email,password_hash) VALUES (?,?,?)'); $stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]); fwrite(STDOUT,"Admin account created for $email.\n");
