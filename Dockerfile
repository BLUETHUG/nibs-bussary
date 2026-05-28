FROM php:8.2-cli

RUN apt-get update && apt-get install -y libsqlite3-dev && docker-php-ext-install pdo pdo_sqlite

COPY . /app/

RUN mkdir -p /app/storage && chmod -R 777 /app/storage

WORKDIR /app

EXPOSE 8080

CMD php -S 0.0.0.0:${PORT:-8080} -t /app /app/server.php
