# docker-compose
PHP アプリケーション開発のためのサーバ環境を **docker-compose** で構築するサンプルです。
Docker についての**個人的な学習の範疇**であることにご注意を。

----------------

## ファイル構造
<details>
<summary>全体像</summary>
<div>

```
  + /docker
  |  | /apache
  |  |  | # Apache コンテナの定義
  |  |  | /conf
  |  |  |  | # Apache の設定ファイル
  |  |  |  | apache-vhosts.conf
  |  |  |  | php.ini
  |  |  |
  |  |  | Dockerfile
  |  |
  |  | /cli
  |  |  | # CLI コンテナの定義
  |  |  | Dockerfile
  |  |
  |  | /composer
  |  |  | # Composer コンテナの定義
  |  |  | Dockerfile
  |  |
  |  | /mysql
  |  |  | # MySQL コンテナは yml で直接イメージを指定しているので、関連ファイルを置いている
  |  |  | /db_data
  |  |  |  |  （データベース関連のファイル群）
  |  |  |
  |  |  | .env
  |  |
  |  | # Docker システム全体を司る中枢
  |  | .env
  |  | docker-compose.yml
  |
  + /project
     | /app
     |  | # 実際の開発で使用するルートディレクトリ
     |  | /public
     |  |  | # Web エントリポイント
     |  |  | .htaccess
     |  |  | index.php
     |  |
     |  | /src
     |  |  | # アプリケーションのクラス群
     |  |
     |  | # CLI エントリポイント
     |  | commandline
     |  | 
     |  | # その他、アプリケーションの構築に必要なファイルたち
     |
     | /logs
        | /commandline
        |  | # CLI のログ
        |
        | /web
           | # apache のログ
```

</div>
</details>

## 構築においてのポイント

* 各機能ごとにコンテナを分け、独立性を高めました。

  * 共有するデータを保持するだけの **データコンテナ**
  * Web サーバとなる **Apache コンテナ**
  * コマンド実行を行なう **CLI コンテナ**
  * PHP でのアプリケーション開発に必須とも言える **Composer コンテナ**
  * データベースを管理する **MariaDB コンテナ**


* `docker-compose run` コマンドによって、コンテナ内のコマンドを実行可能にしています。

* Composer について、[公式 Docker イメージ](https://hub.docker.com/_/composer) も配布されていますが、内部で使用している PHP のバージョンをコントロールできなかったため、 **php-alpine イメージ** を利用して独自構築しています。

* **PHP 関連のコンテナを3つ**使っているため、`.env` を利用して、PHP のバージョンを一括で変更可能です。

* 一般的に出回っている docker-compose 関連の記事は**コンテナ名**と**サービス名**の区別がつきにくいため、まどろっこしいですが明確に名前を分けています。

## 学習内容として盛り込んだこと

* 機能ごとのコンテナ分割
* コンテナへのファイルのマウント方法
* `docker-compose run` コマンドのためのエントリポイント
* 環境変数の使い方、それによってシステムの挙動を変更すること
* コンテナの依存関係と起動順

## 苦戦したこと

* `docker-compose run` 関連が一番しんどかった。
  マウントしたファイルのパスやらオプションの指定の仕方でかなり沼りました。
* PHP で PDO オブジェクトを作成するところもハマりました。
  **ホスト名には何を書けばいいの！？** って。
* 環境変数の使い方。
  特に**コンテナで利用するイメージ自体を環境変数で切り替えるには**という点が難しかった。

## 今後やってみたいこと

* 某帆船みたいに**メールサーバを独自構築**し、環境によってメールを送信したりしなかったりとかいう面倒な処理をなくしたい。
