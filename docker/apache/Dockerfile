ARG PHP_VER

FROM php:${PHP_VER}-apache

# プロジェクトディレクトリをマウント
VOLUME ["/project"]

# タイムゾーン設定
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# ドライバのインストール
RUN docker-php-ext-install pdo_mysql

# 各種設定ファイル（Apache, PHP）
COPY ./conf/apache-vhosts.conf /etc/apache2/sites-available/000-default.conf
COPY ./conf/php.ini /usr/local/etc/php/php.ini
