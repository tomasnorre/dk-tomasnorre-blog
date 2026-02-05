<!DOCTYPE html>
<html lang="en" x-data="{ showMobileMenu: false, darkMode: $persist(false)}" :data-theme="darkMode ? 'dim' : 'nord'">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

    <meta property="og:title" content="{{ $page->title ? $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
    <meta property="og:type" content="{{ $page->type ?? 'website' }}"/>
    <meta property="og:url" content="{{ $page->getUrl() }}/"/>
    <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}"/>

    @if ($page->cover_image)
        <meta property="og:image" content="{{ $page->baseUrl }}/{{ $page->cover_image }}"/>
    @endif

    <title>{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}</title>

    <link rel="home" href="{{ $page->baseUrl }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon/site.webmanifest">
    <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">
    @viteRefresh()
    <link rel="stylesheet" href="{{ vite('source/_assets/css/main.css') }}">
    <script defer type="module" src="{{ vite('source/_assets/js/main.js') }}"></script>
    <link rel="canonical" href="{{ $page->getUrl() }}/">
</head>

<body class="flex flex-col justify-between min-h-screen leading-normal font-sans bg-base-200">
<header class="flex items-center shadow bg-base-300 border-b h-24 py-4" role="banner">
    <div class="container flex items-center max-w-8xl mx-auto px-4 lg:px-8">
        <div class="flex flex-1 items-center">
            <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                <img src="/assets/images/tomasnorre_small.png" alt="Logo showing me as a cartoon like character"
                     class="h-12 mr-2">
                <h2 class="text-lg md:text-2xl my-0">{{ $page->siteName }}</h2>
            </a>
        </div>
        <div id="vue-search" class="flex flex-1 justify-end items-center">
            @include('_components.search')

            @include('_nav.menu')

            @include('_nav.menu-toggle')
            @include('_nav.mode-toggle')
        </div>
    </div>
</header>

@include('_nav.menu-responsive')

<main class="max-w-6xl mx-auto px-4 py-10 bg-base-200 text-base-content">
    @yield('body')
</main>

<footer class="bg-base text-center text-sm mt-12 py-4" role="contentinfo">
    <p id="footer-links" class="mb-8 flex items-center justify-center w-full gap-4">
        <a href="https://twitter.com/tomasnorre" class="link link-primary link-hover" aria-label="Link to my Twitter profile">
            <i class="fill-current text-2xl fa-brands fa-square-x-twitter"></i>
        </a>
        <a href="https://github.com/tomasnorre" class="link link-primary link-hover" aria-label="Link to my GitHub profile">
            <i class="fill-current text-2xl fa-brands fa-github"></i>
        </a>
        <a href="https://phpc.social/@tomasnorre" class="link link-primary link-hover" aria-label="Link to my Mastodon profile">
            <i class="fill-current text-2xl fa-brands fa-mastodon"></i>
        </a>
        <a href="https://www.linkedin.com/in/tomasnorre/" class="link link-primary link-hover" aria-label="Link to my LinkedIn profile">
            <i class="fill-current text-2xl fa-brands fa-linkedin"></i>
        </a>
        <a href="https://7th-green.com" class="link link-primary link-hover" aria-label="Link to 7th Green">
            <img src="/assets/img/7th-green-logo.svg" class="h-5 inline mb-1" alt="7th Green logo, showing 3 elephants">
        </a>
    </p>
    <div class="flex flex-col md:flex-row justify-center text-base-content">
        <span class="md:mr-2">
            &copy; <a href="{{ $page->baseUrl }}" title="Tomas Norre">Tomas Norre</a> {{ date('Y') }}.
        </span>

        <span>
            Built with <a href="http://jigsaw.tighten.co" class="link link-primary link-hover" title="Jigsaw by Tighten"
                          aria-label="Link to Jigsaw by Tightens website, the tool used for this blog">Jigsaw</a>
            and <a href="https://tailwindcss.com"  class="link link-primary link-hover" title="Tailwind CSS, a utility-first CSS framework"
                   aria-label="Link to Tailwindcss website, the css framework used for this blog">Tailwind CSS</a>.
        </span>
    </div>
</footer>
<!-- 100% privacy-first analytics -->
<script async defer src="https://scripts.simpleanalyticscdn.com/latest.js"></script>
<noscript><img src="https://queue.simpleanalyticscdn.com/noscript.gif" alt=""
               referrerpolicy="no-referrer-when-downgrade"/></noscript>
</body>
</html>
