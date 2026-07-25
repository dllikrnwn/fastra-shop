FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring gd xml bcmath ctype zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE $PORT

CMD php artisan serve --host=0.0.0.0 --port=$PORT
