---
extends: _layouts.post
section: content
title: PHP 8.4 on Ubuntu 24.10
date: 2024-12-27
description: PHP 8.4 on Ubuntu 24.10
cover_image: /assets/img/posts/php84-on-ubuntu-2410.jpg
cover_credit: 'Photo by <a href="https://unsplash.com/@benofthenorth">Ben Griffiths</a> on <a href="https://unsplash.com/photos/blue-elephant-figurine-on-macbook-pro-Bj6ENZDMSDY">Unsplash</a>'
cover_alt: 'Elephpant on MacBook'
featured: true
categories: [development]
---

As of December 2024, the Ondřej Surý PPA does not provide support for Ubuntu 24.10. This limitation affects the installation of PHP versions, including PHP 8.4, on this Ubuntu release.

To install PHP 8.4 on Ubuntu 24.10, you can modify the PPA's configuration to use packages from Ubuntu 24.04 (Noble). Here's how:

1. **Remove and Re-add the Ondřej Surý PPA:**
```shell 
sudo add-apt-repository --remove ppa:ondrej/php
sudo add-apt-repository ppa:ondrej/php 
```
This ensures a clean configuration of the PPA.

2. **Modify the PPA's Release Suite:**
```shell 
sudo sed -i 's/oracular/noble/g' /etc/apt/sources.list.d/ondrej-ubuntu-php-oracular.sources
```
This command changes the release suite from 'oracular' (24.10) to 'noble' (24.04), allowing you to access PHP packages intended for Ubuntu 24.04.

3. **Update Package Lists:**

```shell 
sudo apt update
```
This refreshes your package lists to include the modified PPA configuration.

4. **Install PHP 8.4:**

```shell
sudo apt install php8.4
```
This installs PHP 8.4 from the modified PPA.

**Important Considerations:**

* Compatibility: Using packages from a different Ubuntu release can lead to compatibility issues. Proceed with caution and test thoroughly.
* Official Support: This method is a workaround and may not be officially supported. Monitor for any issues and consider consulting official Ubuntu or PHP resources for guidance.

By following these steps, you can install PHP 8.4 on Ubuntu 24.10 despite the lack of direct support from the Ondřej Surý PPA.

Have fun coding.

