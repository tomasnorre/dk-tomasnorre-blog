---
extends: _layouts.post
section: content
title: Jigsaw - replace vue with Alpine.js
date: 2025-06-06
description: Jigsaw - replace vue with Alpine.js
cover_image: /assets/img/posts/jigsaw-replace-vue-with-alpinejs.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@ttepavac?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Tanja Tepavac</a> on <a href="https://unsplash.com/photos/a-piece-of-a-puzzle-with-a-missing-piece-cWMhxNmQVq0?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Blue jigsaw puzzle, with a missing piece in the center'
featured: true
categories: [development,blog]
---

After updating to version 1.8.0 of [tightenco/jigsaw](https://jigsaw.tighten.com/), 
I saw that their [blog-repository](https://github.com/tighten/jigsaw-blog-template) had been updated to use [Alpine.js](https://alpinejs.dev/) instead of vue for the search. 
So I decided to update my blog, to be a little more up to date, as vue seem to be overkill for that one component.

I'll list the steps needed.

1. Update your `package.json`
2. Create a `search.blade.php` in the `_components`-folder
3. Adjust your layout file `_layouts/master.blade.php`
4. Adjust your `webpack.mix.js`-file
5. Update your `main.js`
6. Update your css
7. Delete old vue search component
8. Recompile your site

#### 1. Update your `package.json`

```diff
-       "vue": "^3.5.16",
-       "vue-loader": "^17.4.2",
-       "vue-template-compiler": "^2.7.16"
+       "alpinejs": "^3.14.1",
```

#### 2. Create a `search.blade.php` in the `_components`-folder

```php
<div x-data="{
        init(){
            window.axios('/index.json')
                .then(response => {
                    this.fuse = new window.Fuse(response.data, {
                            minMatchCharLength: 6,
                            keys: ['title', 'snippet', 'categories'],
                        });
                    });
        },
        get results() {
            return this.query ? this.fuse.search(this.query) : [];
        },
        get isQuerying() {
            return Boolean( this.query );
        },
        fuse: null,
        searching: false,
        query: '',
        showInput() {
            this.searching = true;
            this.$nextTick(() => {
                this.$refs.search.focus();
            })
        },
        reset() {
            this.query = '';
            this.searching = false;
        },
    }"
     x-cloak
     class="flex flex-1 justify-end items-center text-right px-4"
>
    <div
            class="absolute md:relative w-full justify-end bg-white left-0 top-0 z-10 mt-7 md:mt-0 px-4 md:px-0"
            :class="{'hidden md:flex': ! searching}"
    >
        <label for="search" class="hidden">Search</label>

        <input
                id="search"
                x-model="query"
                x-ref="search"
                class="relative block h-10 w-full lg:w-1/2 lg:focus:w-3/4 bg-gray-100 border border-gray-500 focus:border-blue-400 outline-none cursor-pointer text-gray-700 px-4 pb-0 pt-px transition-all duration-200 ease-out bg-[url('/assets/img/magnifying-glass.svg')] bg-no-repeat bg-[0.8rem] indent-[1.2em]"
                :class="{ 'rounded-b-none rounded-t-lg': query, 'rounded-3xl': !query }"
                autocomplete="off"
                name="search"
                placeholder="Search"
                type="text"
                @keyup.esc="reset"
                @blur="reset"
        >

        <button
                x-show="query || searching"
                class="absolute top-0 right-0 leading-snug font-400 text-3xl text-blue-500 hover:text-blue-600 focus:outline-none pr-7 md:pr-3"
                @click="reset"
        >&times;</button>

        <div
                x-show="isQuerying"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-none"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute left-0 right-0 md:inset-auto w-full lg:w-3/4 text-left mb-4 md:mt-10"
        >
            <div class="flex flex-col bg-white border border-b-0 border-t-0 border-blue-400 rounded-b-lg shadow-search mx-4 md:mx-0">
                <template x-for="(result, index) in results">
                    <a
                            class="bg-white hover:bg-blue-100 border-b border-blue-400 text-xl cursor-pointer p-4"
                            :class="{ 'rounded-b-lg': (index === results.length - 1) }"
                            :href="result.item.link"
                            :title="result.item.title"
                            :key="result.link"
                            @mousedown.prevent
                    >
                        <span x-html="result.item.title"></span>

                        <span class="block font-normal text-gray-700 text-sm my-1" x-html="result.item.snippet"></span>
                    </a>
                </template>
                <div
                        x-show="! results.length"
                        class="bg-white w-full hover:bg-blue-100 border-b border-blue-400 rounded-b-lg shadow cursor-pointer p-4"
                >
                    <p class="my-0">No results for <strong x-html="query"></strong></p>
                </div>
            </div>
        </div>
    </div>

    <button
            title="Start searching"
            type="button"
            class="flex md:hidden bg-gray-100 hover:bg-blue-100 justify-center items-center border border-gray-500 rounded-full focus:outline-none h-10 px-3"
            @click.prevent="showInput"
    >
        <img src="/assets/img/magnifying-glass.svg" alt="search icon" class="h-4 w-4 max-w-none">
    </button>
</div>
```

#### 3. Adjust your layout file `_layouts/master.blade.php`

```patch 
- <search></search>
+ @include('_components.search')
```

#### 4. Adjust your `webpack.mix.js`-file

```patch 
- mix.js('source/_assets/js/main.js', 'js').vue()
+ mix.js('source/_assets/js/main.js', 'js')
```

#### 5. Update your `main.js`

```patch
- import { createApp } from 'vue';
+ import Alpine from "alpinejs";
+ import Fuse from "fuse.js";

+ window.Fuse = Fuse;
+ window.Alpine = Alpine;
+ Alpine.start();

- import Search from './components/Search.vue';
- const app = createApp({
-    components: {
-        Search,Add commentMore actions
-    }
- });
- app.mount('#vue-search');
```

#### 6. Update your css

```css
[x-cloak] { display: none !important; }
```

#### 7. Delete old vue search component

```bash
rm source/_assets/js/components/Search.vue
```

#### 8. Recompile your site

```bash
npm run dev
npm run prod
```

Now you should be good to go.