FROM php:8.5-fpm-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Композер ставим из официального образа, а не curl | php
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Установка symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony \
    && chmod +x /usr/local/bin/symfony

# Установка PATH глобально
ENV PATH="/usr/local/bin:${PATH}"

# Добавление юзера
RUN useradd -m -u 1000 dev-user

WORKDIR /var/www/app
RUN chown dev-user:dev-user /var/www/app

# Сначала только манифесты composer — слой с зависимостями
# пересобирается лишь при изменении composer.json/lock,
# а не при каждом изменении исходников
COPY --chown=dev-user:dev-user composer.json composer.lock ./
USER dev-user
RUN composer install --no-scripts --no-autoloader --no-interaction --no-progress

COPY --chown=dev-user:dev-user . .
RUN composer dump-autoload --optimize

USER root
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
USER dev-user

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
