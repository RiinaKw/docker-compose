<?php

$path = $_SERVER['PATH_INFO'] ?? '/';

switch ($path) {
    case '/':
        echo "It works<br />\n";
        echo "in the directory " . __DIR__;
        break;

    case '/phpinfo':
        phpinfo();
        break;

    default:
        throw new Exception("Unknown route '{$path}'");
}
