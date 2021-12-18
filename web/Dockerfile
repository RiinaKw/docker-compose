FROM php:8.1-apache

VOLUME ["/project"]

# timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# apache.conf, php.ini
COPY ./conf/apache-vhosts.conf /etc/apache2/sites-available/000-default.conf
COPY ./conf/php.ini /usr/local/etc/php/php.ini
