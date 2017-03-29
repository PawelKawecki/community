FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client \
	    && docker-php-ext-install mcrypt pdo_mysql

WORKDIR /var/www

FROM nginx:1.10

ADD docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www