---
extends: _layouts.post
section: content
title: Resize harddisk in Proxmox VM
date: 2025-08-22
description: Resize harddisk in Proxmox VM
cover_image: /assets/img/posts/resize-harddisk-in-proxmox-vm.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@artwall_hd?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Art Wall - Kittenprint</a> on <a href="https://unsplash.com/photos/black-and-silver-turntable-on-black-table-9Wq1HpghQ4A?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Mechanical Harddisk'
featured: true
categories: [devops,linux]
---

From time to time one would want/need to resize the disk size of a [Proxmox VM](https://www.proxmox.com/). This can be done fairly easy with some few steps. 

**Log into your proxmox**

```text
* find the wanted VM
* select hardware
* select Hard Disk
* click disk actions
* resize
* add the addtional GBs wanted
```

**Log into the VM with ssh**
```bash
sudo growpart /dev/sda 3 #(3 being the partion number)
sudo resize2fs /dev/sda3
sudo reboot
```

Now you have resized your VM harddisk.






