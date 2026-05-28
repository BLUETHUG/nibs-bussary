FROM php:8.2-apache

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_sqlite

RUN a2enmod rewrite

COPY . /var/www/html/

RUN chmod -R 777 storage && \
    chmod +x start.sh && \
    sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["./start.sh"]
