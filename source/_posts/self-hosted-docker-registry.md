---
extends: _layouts.post
section: content
title: Self-hosted Docker Registry
date: 2026-04-13
description: Self-hosted Docker Registry
cover_image: /assets/img/posts/docker-registry.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@fejuz?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Fejuz</a> on <a href="https://unsplash.com/photos/a-large-amount-of-containers-are-stacked-on-top-of-each-other-q6j5mSRpi50?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'A lot of shipping containers'
featured: true
categories: [development,devops,opensource]
---

Self-hosting is getting more and more popular regardless if we are talking homelabs or on-premise.

I like to host a lot of my things myself for the following reasons

* learning opportunity
* privacy
* costs

One service that I host my self, both in my homelab and on-premise is a Docker Registry. A docker registry is a storage option for docker images. 
I use docker images for multiple things, the ones being public are stored public, but I have private images too. 

## Setting up with Docker Compose

Setting up a Docker Registry is quite straight forward, I use docker compose for this.

If you start creating a docker-compose.yml file
```yaml 
services:
  registry:
    image: registry:latest
    restart: always
    ports:
    - "5000:5000"
    environment:
      REGISTRY_AUTH: htpasswd
      REGISTRY_AUTH_HTPASSWD_REALM: Registry
      REGISTRY_AUTH_HTPASSWD_PATH: /auth/registry.password
      REGISTRY_STORAGE_FILESYSTEM_ROOTDIRECTORY: /data
    volumes:
      - ./data:/data
      - ./auth:/auth
```

Then you need some folders for data and authentication credentials.

```sh 
mkdir -p data auth
```
For creating the authentication file, one can use the `htpasswd`-tool from apache.

```sh 
sudo htpasswd -c /auth/registry.password <username>
```

This will prompt you for a password, to be use for the `<username>`, this will be needed later for authentication against the registry

To have the service running with docker and docker compose, you need to set up docker first.
I'll not walk you through that, but here is a link: [Install Docker Engine on Debian](https://docs.docker.com/engine/install/debian/)

After that is set up, you can boot the service, still will start the service, and detach the process to run in the background

```sh 
docker compose up -d 
```

## Reverse Proxy

As Docker Registry operates under the assumption of https with an SSL certificate, you would need some kind of reverse proxy in front;
this could be [Nginx Proxy Manager](https://nginxproxymanager.com/), [Traefik](https://traefik.io/traefik), [Caddy](https://caddyserver.com/) or a like.

I use Nginx Proxy Manager for most of my use cases.

## Use the Registry

### Login

When you are using the registry from CLI, you would have to login this can be done with the command `docker login` it will
prompt you for a username and password.

```sh 
docker login https://registry.domain.tld
Username: <username>
Password: <password>

Login Succeeded
```

### Simple Dockerfile for testing

```sh 
FROM alpine:latest
```
### Build an image

Before we can push an image, we need to build one

```sh
docker build -f Dockerfile -t registry.domain.tld/alpine:latest .
```

### Push

Now pushing it to the registry

```sh 
docker push registry.domain.tld/alpine:latest 
The push refers to repository [registry.domain.tld/alpine]
8c60ab4201db: Pushed 
589002ba0eae: Pushed 
latest: digest: sha256:2bcc88c96d34411f01d4f709420f11171df91ad651d476039f79dff25b8eb553 size: 855
```

### Pull

We can pull it for local use, if deleted locally since building it

```sh 
docker pull registry.domain.tld/alpine:latest
```

### Watch the images

You can visit the URL of the registry with https://registry.domain.tld/v2/_catalog type in your credentials, and you will 
see which images are available.

### Use in CI

In the `Use in CI`-example I'm using GitLab CI

```yaml 
stages:
  - Docker Images

# https://docs.gitlab.com/ee/ci/docker/using_docker_build.html#docker-in-docker-with-tls-disabled-in-the-docker-executor
variables:
  # This instructs Docker not to start over TLS.
  DOCKER_TLS_CERTDIR: ""
  DOCKER_HOST: tcp://docker:2375

before_script:
  - export DOCKER_USERNAME=$DOCKER_USERNAME
  - export DOCKER_PASSWORD=$DOCKER_PASSWORD

default:
  image: docker:29.4.0
  services:
    - name: docker:29.4.0-dind
      alias: docker
      command: ["--tls=false"]

alpine:
  stage: Docker Images
  script:
    - docker login -u $DOCKER_USERNAME -p $DOCKER_PASSWORD https://registry.domain.tld
    - docker build -f Dockerfile -t registry.domain.tld/alpine:latest .
    - docker push registry.domain.tld/alpine:latest
```

Have fun with your private registry.

