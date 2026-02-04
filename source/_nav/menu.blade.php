<nav id="menu" class="hidden lg:flex items-center justify-end text-lg">
    <a title="Blog" href="/"
        class="ml-6 link link-primary no-underline {{ $page->isActive('/') ? 'active' : '' }}">
        Blog
    </a>

    <a title="About" href="/about"
        class="ml-6 link link-primary no-underline {{ $page->isActive('/about') ? 'active' : '' }}">
        About
    </a>

    <a title="Contact" href="/privacy"
        class="ml-6 link link-primary no-underline {{ $page->isActive('/privacy') ? 'active' : '' }}">
        Privacy
    </a>
</nav>
