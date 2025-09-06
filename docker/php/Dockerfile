FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip

# Установка композера
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

# Установка symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony \
    && chmod +x /usr/local/bin/symfony

# Установка PATH глобально
ENV PATH="/usr/local/bin:${PATH}"

# Создание рабочей директории
WORKDIR /var/www/app
COPY src .

# Добавление юзера и прав
RUN useradd -m -u 1000 dev-user
RUN chown -R dev-user:dev-user /var/www/app

USER dev-user

# Команда по умолчанию
CMD ["php-fpm"]
