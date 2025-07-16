---
extends: _layouts.post
section: content
title: Switch to alpinejs for mobile menu toggle
date: 2025-07-16
description: Switch to alpinejs for mobile menu toggle
cover_image: /assets/img/posts/alpinejs-for-mobile-menu.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@skyfly_rich?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Richard Lu</a> on <a href="https://unsplash.com/photos/snow-capped-mountains-under-a-bright-blue-sky-lv4FkwmqjEs?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Snow covered mountains'
featured: true
categories: [development,blog]
---

I'm not really a frontend developer kind of person, so I try to keep it as simple as possible, [Alpine.js](https://alpinejs.dev) helps me with that.
Below you can see the diff, or [directly on GitHub if you prefer.](https://github.com/tomasnorre/dk-tomasnorre-blog/commit/e17908bd6b9a9cccd371aa0d083f29f908bf7ca4)

Now I don't have a single line of custom JavaScript in on my blog, that is custom written. 
The commit changed 7 lines, and delete 30, so less code, easier to maintain.

`sources/_layouts/main.blade.php`
```patch
- <body class="flex flex-col justify-between min-h-screen bg-gray-100 text-gray-800 leading-normal font-sans">
+ <body class="flex flex-col justify-between min-h-screen bg-gray-100 text-gray-800 leading-normal font-sans"
+       x-data="{ showMobileMenu: false}">
```

```patch
- <!-- Scripts for nav menu toogle -->
- @stack('scripts')
```

`source/_nav/menu-responsive.blade.php`
```patch 
- <nav id="js-nav-menu" class="nav-menu hidden lg:hidden">
+ <nav id="js-nav-menu" class="nav-menu" x-show="showMobileMenu">
```
`source/_nav/menu-toggle.blade.php`
```patch
  <button class="flex justify-center items-center bg-blue-500 border border-blue-500 h-10 px-5 rounded-full lg:hidden focus:outline-none"
-    onclick="navMenu.toggle()"
- >
+        x-on:click="showMobileMenu = !showMobileMenu">

     <svg id="js-nav-menu-show" xmlns="http://www.w3.org/2000/svg"
          class="fill-current text-white h-9 w-4" viewBox="0 0 32 32"
+         x-show="!showMobileMenu"
     >
        <path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z"/>
    </svg>

    <svg id="js-nav-menu-hide" xmlns="http://www.w3.org/2000/svg"
-        class="hidden fill-current text-white h-9 w-4" viewBox="0 0 36 30"
+        class="fill-current text-white h-9 w-4" viewBox="0 0 36 30"
+         x-show="showMobileMenu"
    >
        <polygon points="32.8,4.4 28.6,0.2 18,10.8 7.4,0.2 3.2,4.4 13.8,15 3.2,25.6 7.4,29.8 18,19.2 28.6,29.8 32.8,25.6 22.2,15 "/>
    </svg>
  </button>
- 
- @push('scripts')
- <script>
-     const navMenu = {
-         toggle() {
-             const menu = document.getElementById('js-nav-menu');
-             menu.classList.toggle('hidden');
-             menu.classList.toggle('lg:block');
-             document.getElementById('js-nav-menu-hide').classList.toggle('hidden');
-             document.getElementById('js-nav-menu-show').classList.toggle('hidden');
-         },
-     }
- </script>
- @endpush
```