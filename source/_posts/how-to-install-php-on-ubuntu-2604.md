---
extends: _layouts.post
section: content
title: How to install PHP on Ubuntu 26.04
date: 2026-10-14
description: How to install PHP on Ubuntu 26.04
cover_image: /assets/img/posts/how-to-install-php-on-ubuntu-2604.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@kobuagency?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">KOBU Agency</a> on <a href="https://unsplash.com/photos/hello-world-text-67L18R4tW_w?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Cardboard person in front of wall with PHP hello world example'
featured: true
categories: [development,linux,ubuntu]
related_slugs:
  - php84-on-ubuntu-2410
---

The PPA from Ondřej Surý does is about to be migrated to https://packages.sury.org/php/, so to use that instead of the current PPA, you can follow these steps:

```bash
# Remove old PPA
sudo rm /etc/apt/sources.list.d/ondrej-ubuntu-php-*

# Install dependencies
sudo apt install -y ca-certificates curl lsb-release

# Download and install the keyring
curl -fsSLo /tmp/debsuryorg-archive-keyring.deb https://packages.sury.org/debsuryorg-archive-keyring.deb
sudo dpkg -i /tmp/debsuryorg-archive-keyring.deb
echo "deb [signed-by=/usr/share/keyrings/debsuryorg-archive-keyring.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list

# Update package lists
sudo apt update

# Install PHP version of your choice
sudo apt install php[version]
```

##I have multiple PHP versions installed, what to do then?

Don't worry — Ubuntu has a built-in option to easily set your default PHP version using the command line. 
If you choose auto mode, the system will automatically select the alternative with the highest priority.

This means that if a newer version of PHP is installed with a higher priority, the system will switch to it without 
requiring manual intervention. For example, if PHP 7.4 is currently running in auto mode and you install PHP 8.2 
with a higher priority (such as 100), the system will automatically switch to PHP 8.2.

```bash
sudo update-alternatives --config php
[sudo] password for tomas:
There are 6 choices for the alternative php (providing /usr/bin/php).

  Selection    Path             Priority   Status
------------------------------------------------------------
  0            /usr/bin/php8.4   84        auto mode
  1            /usr/bin/php7.4   74        manual mode
  2            /usr/bin/php8.0   80        manual mode
  3            /usr/bin/php8.1   81        manual mode
  4            /usr/bin/php8.2   82        manual mode
* 5            /usr/bin/php8.3   83        manual mode
  6            /usr/bin/php8.4   84        manual mode
```