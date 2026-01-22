---
extends: _layouts.post
section: content
title: TYPO3 Crawler with TYPO3 14 Support
date: 2026-01-22
description: TYPO3 Crawler with TYPO3 14 Support
cover_image: /assets/img/posts/TYPO3-Crawler-with-TYPO3-14-Support.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@matthewwaring?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Matthew Waring</a> on <a href="https://unsplash.com/photos/round-life-buoy-MJAoiige14E?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Wall with a Life Ring'
featured: true
categories: [development,typo3,opensource]
---

Earlier this week, TYPO3 14.1 was released, I'm happy to announce that the TYPO3 Crawler (dev-main branch), now supports TYPO3 14 and PHP 8.5.

There is no release yet of the TYPO3 Crawler, but one can you dev-main if you want to. 

The changes happened so far.
```txt
Crawler dev-main as of 22nd of January 2026

Added
* PHP 8.5 Support
* TYPO3 14 Support

Changed
* Updated symfony-components dependencies to ^7.2
* Updated PHPUnit to ^11.5

Removed
* PHP 8.1 Support
* TYPO3 12 LTS Support
* Remove CodeCeption Tests and its dependencies
* Remove pageVeto in PageService
* JsonCompatibilityConverter-class removed
```

I will most likely not release a version before the TYPO14 LTS is released later this year. 
But I'll focus on improving the Crawler till then, now I have the chance to introduce breaking changes.

If you find a euro or two extra, I'm still looking for some [GitHub Sponsors](https://github.com/tomasnorre). 

`#HappyCrawling`






