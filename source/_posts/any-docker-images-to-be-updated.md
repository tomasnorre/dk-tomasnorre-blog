---
extends: _layouts.post
section: content
title: Any docker images to be updated?
date: 2022-02-02
description: Check if any docker images should be updated
cover_image: /assets/img/posts/any-docker-images-to-be-updated.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@timelabpro?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Timelab Pro</a> on <a href="https://unsplash.com/s/photos/container?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Overview of a harbour with a lot of containers'
featured: true
categories: [devops]
---

Keeping docker images up to date, can be a challenge, I'm not talking about the images you maintain yourself, but the public ones that you're relying on. 
These needs to be updated from time to time too, but how do you figure out when? How can you monitor this? 

**Disclaimer: This post is heavily inspired by [https://mlohr.com/check-for-docker-image-updates/](https://mlohr.com/check-for-docker-image-updates/)**

I don't know which CI tool you're using, I'm using GitHub Actions, but there ideas below can be applied to GitLab, Circle CI, Jenkins etc.

The script from the blog post, see above, makes it possible to compare the image present, and the newest version of it.
As I'm lazy and want this to be part of my CI I have adjusted it a little.

## Let's start from the minimum.

### Running Local

The script from [https://mlohr.com/check-for-docker-image-updates/](https://mlohr.com/check-for-docker-image-updates/) can be used to scan locally. 

You can save it as `docker-image-update-check.sh` and `chmod +x docker-image-update-check.sh` then you can execute it like the example usage in the script.
This requires that the `gitlab/gitlab-ce`-image is pulled locally, otherwise it will not detect a `local digest` and therefore it will always say that an update is needed.

```bash
#!/bin/bash
# Example usage:
# ./docker-image-update-check.sh gitlab/gitlab-ce update-gitlab.sh

IMAGE="$1"
COMMAND="$2"

echo "Fetching Docker Hub token..."
token=$(curl --silent "https://auth.docker.io/token?scope=repository:$IMAGE:pull&service=registry.docker.io" | jq -r '.token')

echo -n "Fetching remote digest... "
digest=$(curl --silent -H "Accept: application/vnd.docker.distribution.manifest.v2+json" \
	-H "Authorization: Bearer $token" \
	"https://registry.hub.docker.com/v2/$IMAGE/manifests/latest" | jq -r '.config.digest')
echo "$digest"

echo -n "Fetching local digest...  "
local_digest=$(docker images -q --no-trunc $IMAGE:latest)
echo "$local_digest"

if [ "$digest" != "$local_digest" ] ; then
	echo "Update available. Executing update command..."
	($COMMAND)
else
	echo "Already up to date. Nothing to do."
fi
```

### Prepare for CI

If we do small adjustments in the script, taking an image including version as input instead, I have also removed the `COMMAND` param as not needed for my case, we will
get a script that looks like this: 

```bash
#!/bin/bash

IMAGE_WITHOUT_VERSION=$(echo $1 | cut -f 1 -d ':')
IMAGE_WITH_VERSION="$1"

echo "Fetching Docker Image..."
docker pull $IMAGE_WITH_VERSION

echo "Fetching Docker Hub token..."
token=$(curl --silent "https://auth.docker.io/token?scope=repository:$IMAGE_WITHOUT_VERSION:pull&service=registry.docker.io" | jq -r '.token')

echo -n "Fetching remote digest... "
digest=$(curl --silent -H "Accept: application/vnd.docker.distribution.manifest.v2+json" \
  -H "Authorization: Bearer $token" \
  "https://registry.hub.docker.com/v2/$IMAGE_WITHOUT_VERSION/manifests/latest" | jq -r '.config.digest')
echo "$digest"

echo -n "Fetching local digest...  "
local_digest=$(docker images -q --no-trunc $IMAGE_WITHOUT_VERSION)
echo "$local_digest"

if [ "$digest" != "$local_digest" ] ; then
  echo "Update available. Please update..!"
  exit 1
else
  echo "Already up to date. Nothing to do."
fi
exit 0
```

This update will give us the possibility to run the script like follows: `./docker-image-update-check.sh grafana/grafana:8.3.3` 
and it will tell us that an update is present as grafana/grafana:8.3.4 is released. It will not tell us which update is present, but only
that one is present.

Now we have a script that can scan one image, but adding it to our CI, there is most likely more images to be scanned,
so we need to wrap this with some small scripts.

There are multiple ways to boot your images, Docker-compose, docker swarm, kubernetes etc. 
I use docker-compose, and I have a small script that converts my image list to json, which I can use in my GitHub Action Matrix.

First we need a list of images present in our setup. I do this with searching in the repositories `docker-compose.yml`-files

```bash
find . -name 'docker-compose*' -type f | xargs grep 'image:' | awk '{print $3}' | sed "s/'//g" | sort -n | uniq > images.txt
```

Now we have an `images.txt`-file that the next script needs. This script that produces `json` from the `images.txt`-file.  

```bash
#!/bin/bash

# removes already present images.json if any
rm images.json

printf '[' >> images.json
while read -r line; do
  printf "\"%s\"," "$line" >> "images.json";
done < images.txt
printf ']' >> images.json

# Remove the tailing `,` at the last entry in file
sed -i 's/,]/]/' images.json

# echos the file, for use later in GitHub Action
cat images.json
```

### Combine it to a GitHub Action

At this point we are ready to combine this all into a GitHub Action.

```yaml 
name: Check Docker Image Updates

on:
  push:
    branches:
      - "**"
  schedule:
    - cron: '30 0 * * *'

jobs:
  # We create the image.json and outputs it as matrix-public
  provide_image_json:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v2

      - name: Fetch Docker Images (Public)
        run: |
          find . -name 'docker-compose*' -type f | xargs grep 'image:' | awk '{print $3}' | sed "s/'//g" | sort -n | uniq > images.txt
      
      - id: set-matrix-public
        run: echo "::set-output name=matrix-public::$(./scripts/pipeline/text-to-json-public.sh)"

    outputs:
      matrix-public: ${{ steps.set-matrix-public.outputs.matrix-public }}

  # We are iterating over all the image in the ${{ matrix.image }} 
  update-to-date:
    needs: provide_image_json

    runs-on: ubuntu-latest
    strategy:
      fail-fast: false
      matrix:
        image: ${{fromJson(needs.provide_image_json.outputs.matrix-public)}}

    steps:
      - uses: actions/checkout@v2
      - name: Login to GitHub Container Registry
        uses: docker/login-action@v1

      - name: Check if update exists for image ${{ matrix.image }}
        env:
          IMAGE: ${{ matrix.image }}
        run: |
          IMAGE_WITHOUT_VERSION=$(echo $IMAGE | cut -f 1 -d ':')
          IMAGE_WITH_VERSION="$IMAGE"
          docker pull $IMAGE_WITH_VERSION
          echo "Fetching Docker Hub token..."
          token=$(curl --silent "https://auth.docker.io/token?scope=repository:$IMAGE_WITHOUT_VERSION:pull&service=registry.docker.io" | jq -r '.token')
          echo -n "Fetching remote digest... "
          digest=$(curl --silent -H "Accept: application/vnd.docker.distribution.manifest.v2+json" \
            -H "Authorization: Bearer $token" \
            "https://registry.hub.docker.com/v2/$IMAGE_WITHOUT_VERSION/manifests/latest" | jq -r '.config.digest')
          echo "$digest"
          echo -n "Fetching local digest...  "
          local_digest=$(docker images -q --no-trunc $IMAGE_WITHOUT_VERSION)
          echo "$local_digest"
          if [ "$digest" != "$local_digest" ] ; then
            echo "Update available. Please update..!"
            exit 1
          else
            echo "Already up to date. Nothing to do."
          fi
          exit 0
```

Now we have a GitHub Action that iterates over all images used in the repository, declared in `docker-compose.yml` files.

This now gives me an overview of images that needs to be updated. In this case no one, the job will fail if updates are needed.
![GitHub Action Updates](/assets/img/posts/gha_updates_action.png "GitHub Action Updates")

## Conclusion

There might be better ways to do this, but this is solution that I came up with for now.
So if you have input and suggestions please reach out, will be happy to hear about it.

### Additional Info
If you are running this with private images/docker registry, you will need to login and verify of course. Running this on private
repository, will of course eat up quite some build minutes, as all images are pull on every single run. It might be possible to improve this with 
GitHub Action caching or inspecting the images without pulling them.

This is a start, and there are room for improvements.




