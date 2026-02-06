<nav id="menu" class="hidden lg:flex items-center justify-end text-lg">
    <a title="Blog" href="/"
        class="ml-6 text-base-content {{ $page->isActive('/') ? 'active' : '' }}">
        Blog
    </a>

    <a title="About" href="/about"
        class="ml-6 text-base-content {{ $page->isActive('/about') ? 'active' : '' }}">
        About
    </a>

    <a title="Contact" href="/privacy"
       class="ml-6 text-base-content {{ $page->isActive('/privacy') ? 'active' : '' }}">
        Privacy
    </a>
</nav>
