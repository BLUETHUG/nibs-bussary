FROM php:8.2-cli

WORKDIR /app

RUN docker-php-ext-install pdo pdo_sqlite

COPY . /app/

RUN chmod -R 777 storage

EXPOSE 10000

CMD php -S 0.0.0.0:${PORT:-10000} -t /app /app/server.php
