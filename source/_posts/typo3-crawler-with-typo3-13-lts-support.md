---
extends: _layouts.post
section: content
title: TYPO3 Crawler with TYPO3 13 LTS Support
date: 2025-01-29
description: TYPO3 Crawler with TYPO3 13 LTS Support
cover_image: /assets/img/posts/TYPO3-Crawler-with-TYPO3-13-LTS-Support.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@an_ku_sh?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Ankush Minda</a> on <a href="https://unsplash.com/photos/balloons-flying-in-the-sky-TLBplYQvqn0?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Ballons released into the air'
featured: true
categories: [opensource,development,typo3]
---

The "latest" version of the `TYPO3 Crawler 12.0.6` comes with TYPO3 13 LTS support. It's been overdue for too long, but now it's out. 

```txt
Crawler 12.0.6 was released on January 23rd, 2025

Added
* Support for TYPO3 13 LTS

Changed
* ProcessRepository doesn't extend from TYPO3\CMS\Extbase\Persistence\Repository anymore
* QueueRepository doesn't extend from TYPO3\CMS\Extbase\Persistence\Repository anymore
* PageRepository::DOKTYPE_RECYCLER is removed from disallowedDoctypes in PageService for TYPO3 13 LTS
```
Only four days later, a new release was created `12.0.7` , which brought support for PHP 8.4.

```txt
Crawler 12.0.7 was released on January 27th, 2025

Added
* Support for PHP 8.4
```

Both releases can be downloaded from either [Packagist](https://packagist.org/packages/tomasnorre/crawler) or from [TYPO3 Extension Repository](https://extensions.typo3.org/extension/crawler)

I prefer installing it with [composer](https://getcomposer.org/):

```bash
composer require tomasnorre/crawler
```


I'll continue to improve the TYPO3 Crawler, but if you find a euro or two extra, I'm still looking for some [GitHub Sponsors](https://github.com/tomasnorre). `#HappyCrawling`






