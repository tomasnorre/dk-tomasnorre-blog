---
extends: _layouts.post
section: content
title: Robots.txt with Jigsaw
date: 2021-10-24
description: Setting up robots.txt in Jigsaw
cover_image: /assets/img/posts/robots-txt.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@phillipglickman?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Phillip Glickman</a> on <a href="https://unsplash.com/s/photos/robot?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Green Robot in focus'
featured: true
categories: [blog]
---

Setting up a `robots.txt` can be helpful to help search engines what to crawl on your website and what not.

Setting it up within `Jigsaw` is fairly simple. 

**This is how I did it**

Add a `robots.txt` file to `sources/assets/` with the desired content, I have following in mine

```apacheconf
User-Agent: *
Allow: /
Sitemap: https://blog.tomasnorre.dk/sitemap.xml
```

To make sure this is getting published with I have added a small copy instruction to my `npm run prod`-build step.

```json 
"scripts": {
    "prod": "mix --production && cp source/assets/robots.txt build_production/robots.txt"
},
```

This ensures that the `robots.txt` file gets copied to the `build_production`-folder which is the one that I publish at the end.

**Reflection** 

I honestly don't know if this is the most elegant way to solve this, but at least it's simple.
I would be happy to hear, if you have better suggestions.







