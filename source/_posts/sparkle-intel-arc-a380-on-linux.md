---
extends: _layouts.post
section: content
title: Sparkle Intel Arc A380 ELF on Linux
date: 2026-01-14
description:  Sparkle Intel Arc A380 ELF on Linux
cover_image: /assets/img/posts/sparkle-intel-arc-a380.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@jrkorpa?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Jr Korpa</a> on <a href="https://unsplash.com/photos/pink-and-black-wallpaper-9XngoIpxcEo?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Sparkle Intel Arc A380 ELF GPU'
featured: true
categories: [linux,opensource]
---

I recently finished a new build, and the performance gains over my last setup are impressive.

```bash
OS: Ubuntu 24.04.3 LTS x86_64 
Host: X870 GAMING WIFI6 -CF-WCP-ADO 
Kernel: 6.14.0-37-generic 
CPU: AMD Ryzen 9 9950X (32) @ 5.7 GHz 
GPU: Intel DG2 [Arc A380] 
GPU: AMD ATI 78:00.0 Device 13c0 
Memory: 7316MiB / 61885MiB  
```

I'm not a gamer, so I didn't have many requirements for a GPU other than having 2-3 DisplayPorts and being silent. 
After reading about the [Sparkle Intel Arc A380](https://www.sparkle.com.tw/en/A380-ELF), its "Zero-Fan" mode for low temperatures caught my attention. 
Around the same time, I saw the YouTube video [Building the PERFECT Linux PC with Linus Torvalds](https://www.youtube.com/watch?v=mfv0V1SxbNA), 
where they used an Intel Arc B580.

After watching that, I figured if an Intel Arc card is good enough for Linus Torvalds on Linux, it should be good enough for me. 
While I know there are architectural differences between the A380 and the newer B580, I expected the drivers to be well-supported 
across the family. However, I was surprised to find that I currently lack proper fan control on Linux.

The main issue is that my GPU idles at around 50°C, which seems to be the exact threshold where the fans spin up and then
immediately stop. This constant "pulsing" is quite annoying. I see five potential solutions:

    Adjust case fan curves: 
        Make the case fans run faster to lower ambient temps, though this increases overall noise.
    Add more case fans: 
        Improve airflow to keep the GPU below the 50°C trigger point.
    Replace the GPU: 
        Buy a different card with better Linux fan control or a beefier passive heatsink.
    Use Integrated Graphics: 
        Remove the GPU entirely and rely on the processor's iGPU.
    Wait for updates: 
        Hope that improved driver support for fan control is released soon.

For now, I’m frequently using noise-canceling headphones to block it out, but it still bothers me when I’m not wearing them.

Currently, I cannot recommend this GPU for Linux users. I'm not sure how it performs on Windows, as I don't run Windows at all. 
To be fair, I should have researched the specific Linux compatibility more thoroughly before buying, I did see it mentioned on forums, 
so I take responsibility for the oversight. I just wish I had the technical knowledge to write a driver fix myself!
