ARG PHP_VER

FROM php:${PHP_VER}-cli

# プロジェクトディレクトリをマウント
VOLUME ["/project"]
WORKDIR /project/app

# タイムゾーン設定
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# ドライバのインストール
RUN docker-php-ext-install pdo_mysql
