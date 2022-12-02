FROM composer:2 as vendor

RUN composer install

FROM node:16
RUN npm install && npm run prod

RUN ls -la
RUN ls -ls build_production/

FROM nginx:alpine
COPY build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt