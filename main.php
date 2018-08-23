<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/credential.tmp";

$fb = new Fphp\Fphp($email, $pass, $cookieFile);
$login = $fb->login();

var_dump($login);
