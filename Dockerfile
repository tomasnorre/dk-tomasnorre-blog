FROM nginx:alpine
COPY deploy/nginx-default.conf /etc/nginx/conf.d/default.conf
COPY build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt
RUN echo `TZ='Europe/Copenhagen' date` > /usr/share/nginx/html/last_build.txt