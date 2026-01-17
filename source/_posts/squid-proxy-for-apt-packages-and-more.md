---
extends: _layouts.post
section: content
title: Squid proxy for apt packages and more
date: 2024-11-15
description: Squid proxy for apt packages and more
cover_image: /assets/img/posts/squid-proxy.webp
cover_credit: 'Photo by <a href="https://www.pexels.com/photo/a-myopsida-in-water-15559902/">Marissa Farrow</a>'
cover_alt: 'Squid swimming'
featured: true
categories: [devops,linux,ubuntu]
---

Do you have multiple computers on the same network fetching the same packages or content from the internet? Then a proxy server might be right for you.
I'll show you have to set it up.
    
**Prerequisite** 

* Debian based linux installation
  * Can be a Virtual Machine, a server, a Proxmox LXC container etc.
* Internet access from that host
* Accessible from other computers in the network e.g. on `192.168.1.200` 
  * `192.168.1.200` will be used as ip in the rest of the post

## Installation and Setup

```bash
$ sudo apt update
$ sudo apt install squid
```
Squid will automatically setup a service running in the background, you can check it out with

```bash
$ sudo systemctl status squid
```
output should look something like this 
```bash
● squid.service - Squid Web Proxy Server
     Loaded: loaded (/lib/systemd/system/squid.service; enabled; preset: enabled)
     Active: active (running) since Mon 2024-10-21 12:41:14 CEST; 3 weeks 4 days ago
       Docs: man:squid(8)
   Main PID: 240 (squid)
      Tasks: 20 (limit: 38309)
     Memory: 624.4M
        CPU: 5min 37.765s
     CGroup: /system.slice/squid.service
             ├─  240 /usr/sbin/squid --foreground -sYC
             ├─  246 "(squid-1)" --kid squid-1 --foreground -sYC
             ├─  252 "(logfile-daemon)" /var/log/squid/access.log
             └─70223 "(pinger)"
```

**Adjust the configuration**

As the default `/etc/squid/squid.conf` is **huge**, you would like to only include the basics.
I suggest you to paste following as the default configuration in `/etc/squid/squid.conf` , that should enable you to proxy most traffic from local networks. 

```apacheconf
acl localhost src 127.0.0.1/32 ::1
acl to_localhost dst 127.0.0.0/8 0.0.0.0/32 ::1
acl localnet src 10.0.0.0/8         # RFC1918 possible internal network
acl localnet src 172.16.0.0/12      # RFC1918 possible internal network
acl localnet src 192.168.0.0/16     # RFC1918 possible internal network
acl SSL_ports port 443
acl Safe_ports port 80              # http
acl Safe_ports port 21              # ftp
acl Safe_ports port 443             # https
acl Safe_ports port 70              # gopher
acl Safe_ports port 210             # wais
acl Safe_ports port 1025-65535      # unregistered ports
acl Safe_ports port 280             # http-mgmt
acl Safe_ports port 488             # gss-http
acl Safe_ports port 591             # filemaker
acl Safe_ports port 777             # multiling http
acl CONNECT method CONNECT

http_access allow manager localhost
http_access deny manager
http_access deny !Safe_ports
http_access deny CONNECT !SSL_ports
http_access allow localnet
http_access allow localhost
http_access deny all
http_port 3128
maximum_object_size 1024 MB
cache_dir aufs /var/spool/squid 5000 24 256
coredump_dir /var/spool/squid3
refresh_pattern ^ftp:       1440    20% 10080
refresh_pattern ^gopher:    1440    0%  1440
refresh_pattern -i (/cgi-bin/|\?) 0 0%  0
refresh_pattern (Release|Packages(.gz)*)$      0       20%     2880
refresh_pattern .       0   20% 4320
refresh_all_ims on
```

After adjusting the `/etc/squid/squid.conf` file, you would need to restart `squid`

```bash
$ sudo systemctl restart squid
```

Now you are ready to configure your local apt-proxy,  by adding the file `/etc/apt/apt.conf.d/00-proxy`
```apacheconf
Acquire::http::Proxy "http://192.168.1.200:3128/";
Acquire::https::Proxy "http://192.168.1.200:3128/";
```

Now you can use `apt` as you usually would, and it would fetch it packages through the proxy. If you want
you can also configure firefox to use the same proxy for your browser content.

Have fun.

If you want to read more, you can see the article on <a href="https://www.digitalocean.com/community/tutorials/how-to-set-up-squid-proxy-on-ubuntu-22-04">https://www.digitalocean.com/community/tutorials/how-to-set-up-squid-proxy-on-ubuntu-22-04</a>

