FROM php:7.3-apache

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN a2enmod rewrite

EXPOSE 80

ADD www /var/www/html

#COPY . /usr/src/myapp
#WORKDIR /usr/src/myapp
#CMD [ "php", "-S", "0.0.0.0:80", "./app.php" ]
