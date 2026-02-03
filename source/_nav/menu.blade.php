<nav id="menu" class="hidden lg:flex items-center justify-end text-lg">
    <a title="Blog" href="/"
        class="ml-6 link link-primary  hover:text-blue-600 {{ $page->isActive('/') ? 'active text-blue-600' : '' }}">
        Blog
    </a>

    <a title="About" href="/about"
        class="ml-6 text-base-content hover:text-blue-600 {{ $page->isActive('/about') ? 'active text-blue-600' : '' }}">
        About
    </a>

    <a title="Contact" href="/privacy"
       class="ml-6 text-base-content hover:text-blue-600 {{ $page->isActive('/privacy') ? 'active text-blue-600' : '' }}">
        Privacy
    </a>
</nav>
