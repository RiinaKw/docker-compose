<?php

$path = $_SERVER['PATH_INFO'] ?? '/';

switch ($path) {
    case '/':
        echo "It works<br />\n";
        echo "in the directory " . __DIR__;
        break;

    case '/phpinfo':
        // 「index.php」って書かなくても http://localhost:12000/phpinfo っていう URL でアクセスできるよ！
        phpinfo();
        break;

    default:
        throw new Exception("Unknown route '{$path}'");
}
