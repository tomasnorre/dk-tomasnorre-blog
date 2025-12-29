---
extends: _layouts.post
section: content
title: Multiple Docker images, One Dockerfile
date: 2025-12-29
description: Multiple Docker images, One Dockerfile
cover_image: /assets/img/posts/multiple-docker-images.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@exdigy?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Dominik Lückmann</a> on <a href="https://unsplash.com/photos/blue-and-red-cargo-ship-on-dock-during-daytime-SInhLTQouEk?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Harbor with Container Ships'
featured: true
categories: [devops]
---

Docker is already loved by many people, so every step to make it a little easier to maintain I find more than welcome.

Often I have Docker images where the only difference is a version constrain e.g. in PHP, in this blog post I'll show 
you have to build multiple docker images with only one dockerfile, it's easy than one would think.

A plain docker file for PHP with composer could look like this

```bash
# Dockerfile
FROM php:8.5-cli-alpine
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apk add icu-dev autoconf gcc git
RUN apk add --update linux-headers
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN apk add --no-cache nodejs npm openssh
```

and your `.gitlab-ci.yml` like this

```yaml
# .gitlab-ci.yml

stages:
  - Docker Images

 # https://docs.gitlab.com/ee/ci/docker/using_docker_build.html#docker-in-docker-with-tls-disabled-in-the-docker-executor
variables:
  # This instructs Docker not to start over TLS.
  DOCKER_TLS_CERTDIR: ""
  DOCKER_HOST: tcp://docker:2375

before_script:
  - export KUBECONFIG=$KUBECONFIG_FILE
  - export DOCKER_USERNAME=$DOCKER_USERNAME
  - export DOCKER_PASSWORD=$DOCKER_PASSWORD
  - export DOCKER_HOSTNAME=$DOCKER_HOSTNAME

php:
  stage: Docker Images
  image: docker:27.1.1
  services:
    - name: docker:27.1.1-dind
      alias: docker
      command: ["--tls=false"]
  rules:
    - changes:
        - PHP/**/*
  script:
    - docker login -u $DOCKER_USERNAME -p $DOCKER_PASSWORD $DOCKER_HOSTNAME
    - docker build -f PHP/Dockerfile -t $DOCKER_HOSTNAME/php:latest .
    - docker push $DOCKER_HOSTNAME/php:latest
```

This is all good and fine, but what if one want to build images for PHP 8.3 through 8.5. With this setup one would 
need a Dockerfile and GitLab CI step for each version. 

As long as there are no differences between images besides versions, it can be solved like this

```bash
# Dockerfile
ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-cli-alpine
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apk add icu-dev autoconf gcc git
RUN apk add --update linux-headers
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN apk add --no-cache nodejs npm openssh
```

```yaml 
# .gitlab-ci.yml

php:
  stage: Docker Images
  rules:
    - changes:
        - PHP/**/*
  parallel:
    matrix:
      - PHP_VERSION: [ "8.3", "8.4", "8.5" ]
  script:
    - docker login -u $DOCKER_USERNAME -p $DOCKER_PASSWORD $DOCKER_HOSTNAME
    - >
      docker build
      --build-arg PHP_VERSION=$PHP_VERSION
      -f PHP/Dockerfile
      -t $DOCKER_HOSTNAME/php:$PHP_VERSION .

    - docker push $DOCKER_HOSTNAME/php:$PHP_VERSION

    # 2. Conditionally tag as "latest" if version is 8.5
    - |
      if [ "$PHP_VERSION" == "8.5" ]; then
        docker tag $DOCKER_HOSTNAME/php:$PHP_VERSION $DOCKER_HOSTNAME/php:latest
        docker push $DOCKER_HOSTNAME/php:latest
      fi
```

This will result in that you have docker images `php:8.3`, `php:8.4`, `php:8.5` and `php:latest` which is refering 
to `php:8.5` in this setup. 

Now when PHP 8.6 is release it quite easy to add the additional version, if nothing changes to the Dockerfile that 
will break the other images. The same way it easy to remove PHP 8.3 when you don't need it for your projects anymore.