FROM php:apache

RUN apt-get update -y

RUN apt-get install -y libpng-dev libjpeg62-turbo-dev

RUN apt-get install -y zlib1g-dev

RUN apt install -y libfreetype6-dev libmcrypt-dev libssl-dev

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install gd

RUN docker-php-ext-install pdo pdo_mysql