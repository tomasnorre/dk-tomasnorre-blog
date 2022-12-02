FROM composer:2 as vendor

WORKDIR /tmp
COPY . /tmp
RUN composer install

FROM node:16

WORKDIR /tmp
COPY . /tmp
RUN npm install && npm run prod

FROM nginx:alpine
WORKDIR /tmp
COPY build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt