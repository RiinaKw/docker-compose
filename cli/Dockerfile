FROM php:8.1-cli

# プロジェクトディレクトリをマウント
VOLUME ["/project"]

# タイムゾーン設定
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# ドライバのインストール
RUN docker-php-ext-install pdo_mysql
