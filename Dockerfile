FROM composer:2 AS builder
WORKDIR /app
COPY . .

RUN apk add --update nodejs npm
RUN composer install --no-dev --optimize-autoloader && npm install && npm run prod

FROM nginx:alpine
COPY config/nginx-default.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt
RUN echo `TZ='Europe/Copenhagen' date` > /usr/share/nginx/html/last_build.txt