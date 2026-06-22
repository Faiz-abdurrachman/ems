FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    curl unzip sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    npm install && npm run build && \
    php artisan key:generate && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080
