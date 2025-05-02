# Usa PHP CLI con PDO PostgreSQL
FROM php:8.1-cli

RUN docker-php-ext-install pdo pdo_pgsql

COPY . /srv/app
WORKDIR /srv/app

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]