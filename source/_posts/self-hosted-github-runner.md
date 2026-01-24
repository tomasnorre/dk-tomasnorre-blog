---
extends: _layouts.post
section: content
title: How to set up a self-hosted GitHub Runner
date: 2026-01-24
description: How to set up a self-hosted GitHub Runner
cover_image: /assets/img/posts/self-hosted-github-runner.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@jadonjohnson?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Jadon Johnson</a> on <a href="https://unsplash.com/photos/a-woman-running-on-a-running-track-at-night-7Dqwq45QfYo?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Person on a running track'
featured: true
categories: [development,devops,ubuntu,linux]
---

There are several reasons to run your own GitHub Runners:

- Lower costs
- More control
- Bigger, more stable runner sizes

The TYPO3 Crawler needs runners that are a bit larger and more stable than GitHub's free tier. I've spun up instances at [Hetzner](https://hetzner.cloud/?ref=ePhFT9oOaEPZ). In this post, I'll walk through how to set one up yourself.

**Disclaimer**

You may need to configure `sudo` for the `ghr` user we create later. It depends on what your GitHub Actions jobs need to do, and many jobs will run fine without it.

The [Hetzner](https://hetzner.cloud/?ref=ePhFT9oOaEPZ) links are affiliate links that help keep the TYPO3 Crawler infrastructure running.

**Prerequisites**

    - A server running Ubuntu or another Debian-based distro (others not tested)
    - Outbound internet access (no inbound access required)

**Install Docker**

You can install Docker using the official script. Line-by-line guides are also available, e.g.
[DigitalOcean - How to Install Docker on Ubuntu - Step-by-Step Guide](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04)

I use the official script:

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

**Install and set up the runner**

In your GitHub repository, go to Settings -> Actions -> Runners and click "New self-hosted runner." GitHub will show you the commands below.

I stop before the `./run.sh` step because I run the runner as a service (shown later).

```bash
# login as ghr e.g. `su - ghr` from your root login
mkdir actions-runner && cd actions-runner
curl -o actions-runner-linux-x64-2.331.0.tar.gz -L https://github.com/actions/runner/releases/download/v2.331.0/actions-runner-linux-x64-2.331.0.tar.gz
echo "5fcc01bd546ba5c3f1291c2803658ebd3cedb3836489eda3be357d41bfcf28a7  actions-runner-linux-x64-2.331.0.tar.gz" | shasum -a 256 -c
tar xzf ./actions-runner-linux-x64-2.331.0.tar.gz

./config.sh --url {GitHubUrl} --token {token} # You get this information from GitHub
```

**Runner hooks**

You can define runner hooks in the `.env` file inside `actions-runner`. I use `ACTIONS_RUNNER_HOOK_JOB_STARTED` to wipe the workspace before each new job.

Create `cleanup.sh`:

```bash
#!/bin/bash
# Use sudo to force-remove the workspace
sudo /usr/bin/rm -rf "$GITHUB_WORKSPACE"
# Re-create it so the runner has a place to land
mkdir -p "$GITHUB_WORKSPACE"
```

Then add this to `.env`:

```
ACTIONS_RUNNER_HOOK_JOB_STARTED=/home/ghr/actions-runner/cleanup.sh
```

**Set up the runner as a service**

The runner tarball already includes the service scripts.

```bash
sudo ./svc.sh install
sudo ./svc.sh start
sudo ./svc.sh status
```

The runner will now start automatically on reboot.

Update your workflow YAML to use it:

```yaml
# Use this in your workflow file for each job
runs-on: self-hosted
```

Have fun!
