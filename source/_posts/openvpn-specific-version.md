---
extends: _layouts.post
section: content
title: OpenVPN Specific Version
date: 2026-01-13
description: OpenVPN Specific Version
cover_image: /assets/img/posts/openvpn-specific-version.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@privecstasy?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Privecstasy</a> on <a href="https://unsplash.com/photos/person-holding-black-iphone-5-CXlqHmQy3MY?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Picture of mobilephone with VPN Protected displayed on the screen'
featured: true
categories: [development,devops]
---

From time to time VPN servers are using older software, so one would need an older OpenVPN version install, which isn't 
always in the repositories of the Linux distribution of choice.

**This posts shows you have to build OpenVPN 2.5.9 from source.**

*Disclaimer*

Building OpenVPN 2.5.9 from source does NOT install:

* NetworkManager OpenVPN plugin
* GUI import capability (.ovpn files)

That functionality is provided by network-manager-openvpn, which is an apt package and is safe to install even if OpenVPN itself is held or removed.

**Install required dependencies**

```bash
sudo apt update
sudo apt install -y build-essential autoconf automake libtool pkg-config \
    libssl-dev liblzo2-dev libpam0g-dev libsystemd-dev gettext wget
```

**Download OpenVPN 2.5.9 Source**

```bash
wget https://swupdate.openvpn.org/community/releases/openvpn-2.5.9.tar.gz
```
Extract: 

```bash 
tar xzf openvpn-2.5.9.tar.gz
cd openvpn-2.5.9/
```

**Configure and Compile**

Configure the build:
```bash
./configure --prefix=/usr/local
```

Compile:
```bash 
make -j$(nproc)
```

Install:
```bash 
sudo make install
```

That installs binaries into `/usr/local/sbin` and config files under `/usr/local/etc/openvpn`.

**Verify Installation**

```bash 
/usr/local/sbin/openvpn --version
```

You should see OpenVPN 2.5.9.

**Symlink and Hold**

To ensure that the package isn't getting overwritten by you package manager, if using `apt` (Debian based distros)
you can do following

```bash 
sudo apt-mark hold openvpn
```

To symlink the already existing `openvpn`-binary you can create a symlink from the newly create installed version.

```bash 
sudo ln -nfs /usr/local/sbin/openvpn /usr/sbin/openvpn
```

Now you are ready to connect to the VPN server.