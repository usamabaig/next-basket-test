FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y git unzip libsqlite3-dev

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI to handle symfony-cmd
RUN wget https://get.symfony.com/cli/installer -O - | bash
ENV PATH="$HOME/.symfony/bin:$PATH"

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite

RUN composer install

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]