FROM composer:2 AS builder
WORKDIR /app
COPY . .

RUN apk add --update nodejs npm
RUN composer install --no-dev --optimize-autoloader && npm install && NODE_ENV=stage npm run build

FROM nginx:alpine
COPY config/nginx-default.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/build_stage/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt
RUN echo `TZ='Europe/Copenhagen' date` > /usr/share/nginx/html/last_build.txt