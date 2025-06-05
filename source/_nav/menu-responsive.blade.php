<nav id="js-nav-menu" class="nav-menu hidden lg:hidden">
    <ul class="my-0">
        <li class="pl-4">
            <a
                title="Blog"
                href="/blog"
                class="nav-menu__item hover:text-blue-500 {{ $page->isActive('/blog') ? 'active text-blue' : '' }}"
            >Blog</a>
        </li>
        <li class="pl-4">
            <a
                title="About"
                href="/about"
                class="nav-menu__item hover:text-blue-500 {{ $page->isActive('/about') ? 'active text-blue' : '' }}"
            >About</a>
        </li>

        <li class="pl-4">
            <a
                    title="Privacy"
                    href="/privacy"
                    class="nav-menu__item hover:text-blue-500 {{ $page->isActive('/privacy') ? 'active text-blue' : '' }}"
            >Privacy</a>
        </li>
    </ul>
</nav>
