FROM composer:2 AS builder
WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && ./vendor/bin/jigsaw build production

FROM nginx:alpine
COPY deploy/nginx-default.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt
RUN echo `TZ='Europe/Copenhagen' date` > /usr/share/nginx/html/last_build.txt