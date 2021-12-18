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

    case '/time':
        echo date(DATE_RFC2822);
        break;

    case '/error':
        // エラーログを確認できるよう、強制的にエラーを発動させる
        header("HTTP/1.1 500 Internal Server Error");
        trigger_error("Test error.", E_USER_ERROR);
        break;

    default:
        header("HTTP/1.1 404 Not Found");
        throw new Exception("Unknown route '{$path}'");
}
