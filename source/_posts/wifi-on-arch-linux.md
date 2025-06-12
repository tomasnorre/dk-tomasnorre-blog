---
extends: _layouts.post
section: content
title: Wifi on Arch Linux
date: 2025-03-15
description: Connect to Wifi in Arch Linux
cover_image: /assets/img/posts/wifi-on-arch-linux.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@lukash?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Lukas</a> on <a href="https://unsplash.com/photos/a-close-up-of-a-cell-phone-on-a-table-uZkHtWsi2dE?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Laptop with Arch Linux sticker'
featured: true
categories: [linux]
---

This is a short intro on how to setup Wifi on Arch Linux.

In your cli you need to run the `iwctl`


```bash
root@archiso # iwctl
NetworkConfigurationEnalbed: disabled
StateDirectory: /var/lib/iwd
Version: 3.14
``` 

The prompt will now look like this.

```bash
[iwd]#
```

Now type the following commands

```bash
[iwd]# device list

                                    Devices                                    
--------------------------------------------------------------------------------
  Name                  Address               Powered     Adapter     Mode      
--------------------------------------------------------------------------------
  wlan0                 04:6c:59:0d:69:7f     on          phy0        station    


[iwd]# station wlan0 scan
[iwd]# station wlan0 get-networks
[iwd]# station wlan0 connect SSID

# type password

[iwd]# station wlan0 show

                                 Station: wlan0                                
--------------------------------------------------------------------------------
  Settable  Property              Value                                          
--------------------------------------------------------------------------------
            Scanning              no                                              
            State                 connected                                        
            Connected network     SSID                                        
            IPv4 address          192.168.10.226                                  
            ConnectedBss          26:5a:4c:14:38:47                                
            Frequency             5240                                            
            Channel               48                                              
            Security              WPA2-Personal                                    
            RSSI                  -73 dBm                                          
            AverageRSSI           -78 dBm                                          
            RxMode                802.11ax                                        
            RxMCS                 3                                                
            TxMode                802.11ax                                        
            TxMCS                 3                                                
            TxBitrate             29200 Kbit/s                                    
            RxBitrate             137600 Kbit/s  
```

You are now connected, have fun with Arch.







