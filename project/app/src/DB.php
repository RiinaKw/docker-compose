<?php

namespace Riina\SampleApp;

use PDO;
use Exception;

class DB
{
    private $props = [];

    public function __construct(string $host, int $port = 3306)
    {
        $this->props['host'] = $host;
        $this->props['port'] = $port;
    }

    public function use(string $db): self
    {
        $this->props['db'] = $db;
        return $this;
    }

    public function dsn(): string
    {
        if (! ($this->props['host'] ?? null)) {
            throw new Exception('ホスト名が指定されていません');
        }
        if (! ($this->props['port'] ?? null)) {
            throw new Exception('ポート番号が指定されていません');
        }
        if (! ($this->props['db'] ?? null)) {
            throw new Exception('データベースが指定されていません');
        }

        $host = $this->props['host'];
        $port = $this->props['port'];
        $db = $this->props['db'];
        return "mysql:dbname={$db};host={$host};port={$port}";
    }

    public function pdo(string $user, string $password): PDO
    {
        return new PDO($this->dsn(), $user, $password);
    }
}
