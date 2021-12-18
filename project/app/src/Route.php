<?php

namespace Riina\SampleApp;

use Exception;

/**
 * PATH_INFO を利用した簡単なルーティング
 */
class Route
{
    /**
     * PATH_INFO によって処理を振り分ける
     */
    public function __construct()
    {
        $path = ltrim(($_SERVER['PATH_INFO'] ?? ''), '/');
        if ($path === '') {
            $this->index();
            return;
        } elseif (is_callable([$this, $path])) {
            $this->$path();
            return;
        }
        $this->unknown($path);
    }

    /**
     * PATH_INFO の指定がなかった場合
     */
    public function index(): void
    {
        echo "It works<br />\n";
        echo "in the directory " . __DIR__;
    }

    /**
     * "/phpinfo" で呼ばれた場合、phpinfo を表示
     */
    public function phpinfo(): void
    {
        phpinfo();
    }

    /**
     * "/time" で呼ばれた場合、タイムゾーンを含めた時刻を表示
     */
    public function time(): void
    {
        echo date(DATE_RFC2822);
    }

    /**
     * "/error" で呼ばれた場合、エラーログで確認できるよう 500 エラーを発生させる
     */
    public function error(): void
    {
        header("HTTP/1.1 500 Internal Server Error");
        trigger_error("Test error.", E_USER_ERROR);
    }

    /**
     * 不明な PATH_INFO の場合、404 エラーを発生させる
     * @param string $path  呼ばれた PATH_INFO
     */
    public function unknown(string $path): void
    {
        header("HTTP/1.1 404 Not Found");
        throw new Exception("Unknown route '{$path}'");
    }
}
