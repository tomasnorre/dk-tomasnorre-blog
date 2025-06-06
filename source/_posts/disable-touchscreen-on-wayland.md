---
extends: _layouts.post
section: content
title: Disable touchscreen on Wayland
date: 2025-04-25
description: Disable touchscreen on Wayland
cover_image: /assets/img/posts/disable-touchscreen-on-wayland.jpg
cover_credit: 'Photo by <a href="https://unsplash.com/@katetrysh?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Kate Trysh</a> on <a href="https://unsplash.com/photos/a-man-is-pointing-at-a-large-poster-LRzkT1gIU8A?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Person click on large touchscreen'
featured: true
categories: [linux]
---

I'm not a fan ouf touchscreen on my laptop, so I was looking for a way to disable it. Now you can disabled it too.

First we need to identify the VID (Vendor ID) and PID (Product ID), this can be done with `lsusb`.

```bash
lsusb

Bus 001 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
Bus 001 Device 002: ID 04f3:2b7c Elan Microelectronics Corp. Touchscreen
Bus 001 Device 003: ID 04f2:b6cb Chicony Electronics Co., Ltd Integrated Camera
Bus 001 Device 004: ID 8087:0026 Intel Corp. AX201 Bluetooth
Bus 002 Device 001: ID 1d6b:0003 Linux Foundation 3.0 root hub
Bus 003 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
Bus 004 Device 001: ID 1d6b:0003 Linux Foundation 3.0 root hub
```

This is the device we are looking for `Bus 001 Device 002: ID 04f3:2b7c Elan Microelectronics Corp. Touchscreen`.
Next we have to create a new udev rule, these are located in `/etc/udev/rules.d/`, the filename is not important, 
I choose `99-disable-touchscreen.rules` to have it loaded as late a possible and to have it saying what's happening.

Edit the file with your favorite editor.

```bash
sudo vim /etc/udev/rules.d/99-disable-touchscreen.rules
```

```
SUBSYSTEM=="usb", ATTRS{idVendor}=="VID", ATTRS{idProduct}=="PID", ATTR{authorized}="0"
```

The `PID` and `VID` needs to be replaced, after replacing it, mine looks like this

```
SUBSYSTEM=="usb", ATTRS{idVendor}=="04f3", ATTRS{idProduct}=="2b7c", ATTR{authorized}="0"
```

Now save the file and exit.

You can now exit reboot your system, or reload the udev rules by running

```bash
sudo udevadm trigger
```

Now your touchscreen should be disabled, enjoy.