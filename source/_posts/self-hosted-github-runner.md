---
extends: _layouts.post
section: content
title: How to set up self-hosted GitHub Runner
date: 2026-01-24
description: How to set up self-hosted GitHub Runner
cover_image: /assets/img/posts/self-hosted-github-runner.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@jadonjohnson?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Jadon Johnson</a> on <a href="https://unsplash.com/photos/a-woman-running-on-a-running-track-at-night-7Dqwq45QfYo?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Person on a running track'
featured: true
categories: [development,devops,ubuntu,linux]
---

Having your own GitHub Runners can have multiple reasons

* Shaving costs
* Control
* Runner sizes

The TYPO3 Crawler have the need for a little bigger and more stable runners that the free-tiers on GitHub. 
I have booted up some instances at my hosting center [Hetzner](https://hetzner.cloud/?ref=ePhFT9oOaEPZ), in this post I will go through how to set one up 
yourself.

**Disclaimer**

You might need to set up a `sudo` file for the `ghr`-user that we create later, but that will depend on which rights your
GitHub Actions will need to run, most job will without it. 

The [Hetzner](https://hetzner.cloud/?ref=ePhFT9oOaEPZ)-links is affiliate links, which will help me keep my infrastructure running for the TYPO3 Crawler.

**Prerequisites**

    * Server Running Ubuntu or other Debian based distro, I haven't tested others
    * Server need to have access to the internet, but doesn't need to be accessible from the internet.

Let's start.

**Install Docker**

Setting up and installing docker can be done with an install script from docker itself. You can also find line for line tutorials on e.g. 
[DigitalOcean - How to Install Docker on Ubuntu – Step-by-Step Guide](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04)

I do it with the script from docker.com

```bash
sudo apt update && sudo apt upgrade -y # Ensure all dependencies are up to date
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
```

**Add user**

```bash
useradd ghr # Answer the questions asked 
usermod -aG sudo ghr
sudo usermod -aG docker ghr
```

**Install and Setup Runner**'

If you go to your GitHub Repository under Settings > Actions > Runners, you will see a button "New self-hosted runner", 
when clicking it, it will show you the commands as below.

I stop before the `./run.sh`-step in the guide, as I run my GitHub Runner as a service. Will show you later. 

```bash
# login as ghr e.g. `su - ghr` from your root login
mkdir actions-runner && cd actions-runner
curl -o actions-runner-linux-x64-2.331.0.tar.gz -L https://github.com/actions/runner/releases/download/v2.331.0/actions-runner-linux-x64-2.331.0.tar.gz
echo "5fcc01bd546ba5c3f1291c2803658ebd3cedb3836489eda3be357d41bfcf28a7  actions-runner-linux-x64-2.331.0.tar.gz" | shasum -a 256 -c
tar xzf ./actions-runner-linux-x64-2.331.0.tar.gz

./config.sh --url {GitHubUrl} --token {token} # You get this information from GitHub 

```

**Runner Hooks**

There are multiple hooks for the runners that can be defined in the `.env`-file of the `actions-runner` directory. 
So far I only use one hook, the `ACTIONS_RUNNER_HOOK_JOB_STARTED` which allows me to wipe the workspace, before starting a new job.

For that I need a `cleanup.sh`-script

```bash
#!/bin/bash
# Use sudo to force remove the problematic directory
sudo /usr/bin/rm -rf "$GITHUB_WORKSPACE"
# Re-create it so the runner has a place to land
mkdir -p "$GITHUB_WORKSPACE"
```

And add the following line to `.env`-file

```
ACTIONS_RUNNER_HOOK_JOB_STARTED=/home/ghr/actions-runner/cleanup.sh
```
**Setup GitHub Runner as a Service**

The GitHub Runner comes with the logic already in the tar.gz that we downloaded earlier, it "just" use it.

```bash
sudo ./svc.sh install
sudo ./svc.sh start
sudo ./svc.sh status
```

Now the GitHub Runner will run and start automatically on server reboot.

You can now adjust your GitHub Action yaml files to 

```yaml 
# Use this YAML in your workflow file for each job
runs-on: self-hosted
```
and you jobs will run on your self-hosted runner.

Have fun!



