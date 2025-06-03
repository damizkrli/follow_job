FROM php:8.2-cli

RUN apt-get update \
  && apt-get install -y unzip zip libzip-dev mariadb-client \
  && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /app

COPY . .

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
