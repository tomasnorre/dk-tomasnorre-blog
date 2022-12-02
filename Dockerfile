FROM nginx:alpine
COPY build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt
RUN echo `date` > /usr/share/nginx/html/last_build.txt