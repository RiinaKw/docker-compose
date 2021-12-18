<?php

namespace Riina\SampleApp;

use PDO;
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
     * "/db" で呼ばれた場合、データベースへの接続を試みる
     * 接続が確立されたら、サーバ内の DB 一覧を取得してみる
     */
    public function db(): void
    {
        // ホスト名には docker-compose.yml で定義したコンテナ名が使用できる
        // docker-compose に書いた「13306」ポートは外向きのものなので、コンテナ内部では利用できない
        $pdo = new PDO('mysql:dbname=db_docker_example;host=example_mysql;port=3306', 'user_example', 'any_password');
        $statement = $pdo->query('SHOW DATABASES;');

        foreach ($statement as $row) {
            var_dump($row);
            echo "<br />\n";
        }
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
