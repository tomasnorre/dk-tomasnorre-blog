---
extends: _layouts.post
section: content
title: Kamal Deploy
date: 2025-06-29
description: Switching from K3S to Kamal Deploy
cover_image: /assets/img/posts/kamal-deploy.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@victoire_jonch?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Victoire Joncheray</a> on <a href="https://unsplash.com/photos/blue-intermodal-container-XsP7GCLMWjM?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'The corner of a blue shipping container with a clear blue sky in the background'
featured: true
categories: [development,devops]
---

After I have been using a total overkill setup for my private hosting a [k3s cluster](https://k3s.io/), for more than two years, I decided to cut some costs and complexity.
I have now switched to a [Kamal Deploy](https://kamal-deploy.org/) setup which is based on Docker. This takes care of SSL certificates from [Let's Encrypt](https://letsencrypt.org/) and deploying containers with zero downtime.

In sort in a Docker based deployment, with a proxy in front that takes care of routing and SSL certificates.

### Prerequisite

* Linux Server with ssh access, I prefer Debian based Linux Distributions.

### Setup

To use Kamal you first need to installed it. It's writing in [Ruby](https://www.ruby-lang.org/en/) so you would need to have that installed.

```bash
gem install kamal
```

After installing it, you run

```bash
kamal init
```

which will generate a boilerplate `config/deploy.yml` and a `.kamal`-directory which is used for secrets and hooks. I have not done any adjustments to the `.kamal`-directory.

As it's a boilerplate file `config/deploy.yml`, there are a lot of section commented out, my `config/deploy.yml` now looks like this.

```yaml
# Name of your application. Used to uniquely configure containers.
service: dk-tomasnorre-blog
# Name of the container image.
image: tomasnorre/blog

# Deploy to these servers.
servers:
  web:
    - 116.203.152.185

# Enable SSL auto certification via Let's Encrypt and allow for multiple apps on a single web server.
proxy:
  ssl: true
  host: blog.tomasnorre.dk

# Credentials for your image host.
registry:
  # Specify the registry server, if you're not using Docker Hub
  server: docker.tomasnorre.dk
  username: registry

  # Always use an access token rather than real password (pulled from .kamal/secrets).
  password:
    - KAMAL_REGISTRY_PASSWORD

# Configure builder setup.
builder:
  arch: amd64
```

As it's all based on docker you would need a `Dockerfile` too, mine look like this

```bash
FROM composer:2 AS builder
WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && ./vendor/bin/jigsaw build production

FROM nginx:alpine
COPY config/nginx-default.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/build_production/. /usr/share/nginx/html
COPY source/assets/robots.txt /usr/share/nginx/html/robots.txt
RUN echo `TZ='Europe/Copenhagen' date` > /usr/share/nginx/html/last_build.txt
```

An important part of Kamal is the `/up`-health check endpoint. You can set up Nginx simply by adding following to your nginx configuration in the `server {}` section.

```apacheconf
    # Health check endpoint for Kamal
    location = /up {
        return 200 'OK';
        add_header Content-Type text/plain;
    }
```

As you can see it's fairly simple, it's a matter of building the static HTML and serving them with Nginx.

### Deployment

After this is done, you can now deploy it with a simple command.

```bash
kamal deploy
```

### Extra

What I have not covered here is the option to used databases like MySQL, Redis and other services together with Kamal.
This can be done with [accessories](https://kamal-deploy.org/docs/configuration/accessories/), which will configure the addtional needed containers for you.