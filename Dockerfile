FROM php:8.3-cli-alpine

WORKDIR /app

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS oniguruma-dev \
    && docker-php-ext-install mbstring \
    && apk del .build-deps

COPY --chown=nobody:nobody . .

USER nobody

ENV PORT=10000
EXPOSE 10000

CMD ["sh", "-c", "exec php -d expose_php=0 -S 0.0.0.0:${PORT:-10000} router.php"]
