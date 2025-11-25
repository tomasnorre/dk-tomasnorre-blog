---
extends: _layouts.post
section: content
title: Debian - Update Bookworm to Trixie
date: 2025-11-25
description: Debian - Update Bookworm to Trixie
cover_image: /assets/img/posts/debian-update-bookworm-to-trixie.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@tvick?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Taylor Vick</a> on <a href="https://unsplash.com/photos/cable-network-M5tzZtFCOfs?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Server racks with multiple servers'
featured: true
categories: [opensource,linux,devops]
---

Like many other you might have choosen to run your servers on [Debian](https://debian.org), me included.

To update to the latest Debian 13 (Trixie), the following steps is required.

**Disclaimer: Always take backups before starting an upgrade like this**

## Make sure current system is up to date
```bash
sudo apt update
sudo apt full-upgrade
```

## Edit sources.list to Debian Trixie

```bash 
/etc/apt/sources.list
/etc/apt/sources.list.d/
```

Example
```diff 
- deb https://ftp.debian.org/debian/ bookworm contrib main non-free non-free-firmware
- deb https://ftp.debian.org/debian/ bookworm-updates contrib main non-free non-free-firmware
- deb https://ftp.debian.org/debian/ bookworm-proposed-updates contrib main non-free non-free-firmware
- deb https://ftp.debian.org/debian/ bookworm-backports contrib main non-free non-free-firmware
- deb https://security.debian.org/debian-security/ bookworm-security contrib main non-free non-free-firmware
+ deb https://ftp.debian.org/debian/ trixie contrib main non-free non-free-firmware
+ deb https://ftp.debian.org/debian/ trixie-updates contrib main non-free non-free-firmware
+ deb https://ftp.debian.org/debian/ trixie-proposed-updates contrib main non-free non-free-firmware
+ deb https://ftp.debian.org/debian/ trixie-backports contrib main non-free non-free-firmware
+ deb https://security.debian.org/debian-security/ trixie-security contrib main non-free non-free-firmware
```

## Update package index

```bash
sudo apt update
```

## Upgrade to Debian 13 (Trixie)

```bash
sudo apt full-upgrade -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confnew" --purge
```

## Reboot

Now you are good to go, and you can work with you newly updated server.
After reboot, you can confirm with 

```bash
lsb_release -a
```


