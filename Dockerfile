FROM php:8.3-fpm

ARG SYMFONY_EN
ENV SYMFONY_EN=${SYMFONY_EN}
ENV APP_ENV=${SYMFONY_EN}

# 1. Update packages & install system dependencies
RUN apt-get update && apt-get install -y \
    nginx ftp lftp unzip git \
    libicu-dev && docker-php-ext-install intl \
    && rm -rf /var/lib/apt/lists/*

# 2. Install PHP extensions
RUN docker-php-ext-install ftp pdo_mysql

# 3. Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/project/
COPY . .

# 4. Copy install script & make executable
COPY docker/install_symfony.sh /usr/local/bin/install_symfony.sh
RUN chmod +x /usr/local/bin/install_symfony.sh

# Debug info (optional)
RUN ls -la /usr/local/bin/install_symfony.sh && \
    cat /usr/local/bin/install_symfony.sh && \
    echo "SYMFONY_EN value: ${SYMFONY_EN}"

# 5. Symfony setup
RUN mkdir -p var/cache/${SYMFONY_EN} var/log \
    && chown -R www-data:www-data var \
    && /usr/local/bin/install_symfony.sh ${SYMFONY_EN} \
    && chown -R www-data:www-data var/cache/${SYMFONY_EN}

# 6. Configure Nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD ["php-fpm"]
