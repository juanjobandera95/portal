<?php
return ['database' => ['name' => 'portal',
    'username' => 'juanjo',
    'password' => '1234',
    'connection' => 'mysql:host=localhost;charset=utf8',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true]],
    "security" => ["roles" => ["ROLE_ADMIN" => 3,
        "ROLE_USER" => 2,
        "ROLE_ANONYMOUS" => 1

    ]]

];
