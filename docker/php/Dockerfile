FROM php:8.4-fpm-alpine

# ===============================
# 1. Устанавливаем системные зависимости
# ===============================
RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    $PHPIZE_DEPS

# ===============================
# 2. Добавляем настройку GD, для работы с изображениями
# ===============================
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp


# ===============================
# 3. Устанавливаем PHP-расширения
# ===============================
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    intl \
    exif \
    gd

# ===============================
# 4. Устанавливаем Composer
# ===============================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===============================
# 5. Настройка PHP
# ===============================
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# ===============================
# 6. Настройка рабочей директории
# ===============================
WORKDIR /var/www

# ===============================
# 7. Пользователь (важно!)
# ===============================
RUN addgroup -g 1000 laravel \
    && adduser -G laravel -g laravel -s /bin/sh -D laravel

USER laravel