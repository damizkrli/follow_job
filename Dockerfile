FROM php:8.2-cli

ARG APP_ENV=prod

RUN apt-get update \
  && apt-get install -y unzip zip libzip-dev mariadb-client git \
  && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN if [ "$APP_ENV" = "prod" ]; then \
  cp .env.local .env; \
  fi

RUN if [ "$APP_ENV" = "dev" ]; then \
  composer install --no-interaction; \
  else \
  composer install --no-scripts --no-interaction --no-dev --optimize-autoloader; \
  fi

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
