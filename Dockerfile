FROM php:8.2-cli

RUN apt-get update \
  && apt-get install -y unzip zip libzip-dev mariadb-client git \
  && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
