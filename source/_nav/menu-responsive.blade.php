<nav id="js-nav-menu" class="nav-menu" x-show="showMobileMenu">
    <ul class="my-0">
        <li class="pl-4">
            <a
                title="Blog"
                href="/"
                class="nav-menu__item {{ $page->isActive('/') ? 'active text-blue' : '' }}"
            >Blog</a>
        </li>
        <li class="pl-4">
            <a
                title="About"
                href="/about"
                class="nav-menu__item {{ $page->isActive('/about') ? 'active text-blue' : '' }}"
            >About</a>
        </li>

        <li class="pl-4">
            <a
                    title="Privacy"
                    href="/privacy"
                    class="nav-menu__item {{ $page->isActive('/privacy') ? 'active text-blue' : '' }}"
            >Privacy</a>
        </li>
    </ul>
</nav>
