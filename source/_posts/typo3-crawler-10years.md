---
extends: _layouts.post
section: content
title: TYPO3 Crawler - 10 Years of contributions
date: 2025-07-14
description: TYPO3 Crawler - 10 Years of contributions
cover_image: /assets/img/posts/typo3-crawler-10years.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@ashleew?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Ashlee Marie</a> on <a href="https://unsplash.com/photos/a-spider-web-with-drops-of-water-on-it-HeDAQuOe77A?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Spiderweb with waterdrops on it'
featured: true
categories: [development,opensource,typo3]
---

Somewhen in 1998, I didn't have the money for buying my Licenses for my Windows, and I started to look for other legal alternatives.
I was then introduced to Linux and Open Source. It took me some months to get use to Linux, but I feel in love with the idea of open source.

I have now been using Linux and primary open source products since then. Later one when I got more into programming I also those the part of 
open source which got me into [TYPO3 CMS](https://typo3.org) in 2004. I haven't looked back since.

## TYPO3 Crawler

The [TYPO3 Crawler ](https://extensions.typo3.org/extension/crawler) was uploaded to the public first time 22nd Dec 2005, so it have been there for quite some time.
Today 10 years ago, on the 14th of July 2015, I did [my very first contribution to the crawler](https://github.
com/tomasnorre/crawler/commit/aaa8cb8f95a7c87a323e7e854543c3d16be0b566
). 


`class.tx_crawler_lib.php`

```patch 
- $pageId = tx_crawler_api::forceIntegerInRange($cliObj->cli_args['_DEFAULT'][2], 0);
+ if (isset($cliObj->cli_args['_DEFAULT'][2])) {
+       // Crawler is called over TYPO3 BE
+		$pageId = tx_crawler_api::forceIntegerInRange($cliObj->cli_args['_DEFAULT'][2], 0);
+ } else {
+       // Crawler is called over cli
+		$pageId = tx_crawler_api::forceIntegerInRange($cliObj->cli_args['_DEFAULT'][1], 0);
+ }

```

Since then, I have become the maintainer of the TYPO3 Crawler, and have commited 624 changes to the extension. 
It's a total of ~80.000 added lines and ~35.000 delete lines of code.

I know the crawler still have a lot of improvements to be done, but I'm trying my best to keep up to date with the community. 
Thankfully a lot of contributes are helping out, I really appreciate that.

`#HappyCrawling`


