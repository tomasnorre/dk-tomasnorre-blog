---
extends: _layouts.post
section: content
title: Jigsaw - Related articles
date: 2026-01-26
description: Jigsaw - Related articles
cover_image: /assets/img/posts/jigsaw-related-articles.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@theshubhamdhage?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Shubham Dhage</a> on <a href="https://unsplash.com/photos/a-group-of-cubes-that-are-on-a-black-surface-T9rKvI3N0NM?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'A grid of cubes connected by wires'
featured: true
categories: [development,blog]
related_slugs:
  - setting-up-a-blog-with-jigsaw
---

Even though [Jigsaw](https://jigsaw.tighten.com/) is a static site generator, it can be made more dynamic and generate related articles too.
In this post I will show you how to do that.

**Create a Listener**

Jigsaw has a concept of [Event listeners](https://jigsaw.tighten.co/docs/event-listeners/#event-listeners)
where you can hook into the build process and add your own logic.

This is what I use for the related articles feature, create `listeners/RelateArticles.php` and add the following code:

```php
<?php
namespace App\Listeners;
use TightenCo\Jigsaw\Jigsaw;

class RelateArticles
{
    public function handle(Jigsaw $jigsaw)
    {
        $posts = $jigsaw->getCollection('posts');

        // Build a map of relations
        $relations = [];
        $posts->each(function ($post) use (&$relations) {
            $currentSlug = $post->getFilename();
            $related = $post->related_slugs ?? [];

            foreach ($related as $relatedSlug) {
                // Link A -> B
                $relations[$currentSlug][] = $relatedSlug;
                // Link B -> A (The Reverse)
                $relations[$relatedSlug][] = $currentSlug;
            }
        });

        // Inject the actual Post objects back into each page
        $posts->each(function ($post) use ($relations, $posts) {
            $slug = $post->getFilename();
            $relatedSlugs = array_unique($relations[$slug] ?? []);

            // Filter the posts collection to find the actual objects
            $post->related_posts = $posts->filter(function ($p) use ($relatedSlugs) {
                return in_array($p->getFilename(), $relatedSlugs);
            });
        });
    }
}
```

**Register the Listener**

In `bootstrap.php` register the listener:

```php
$events->afterCollections(\App\Listeners\RelateArticles::class);
```

**Update the template**

How you want to display the related articles is up to you, but here is an example from my `sources/_layouts/post.blade.php`:

```html
@php
    $hasRelated = $page->related_posts && $page->related_posts->count() > 0;
@endphp

@if($hasRelated)
<div>
    <div>
        <h2>Related Articles</h2>
        <ul>
            @foreach($page->related_posts as $related)
            <li>
                <a href="{{ $related->getUrl() }}">{{ $related->title }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
```

This can be done in multiple ways, but I have done it like that to keep the template as simple as possible.
I have a section being displayed differently based on whether there are related articles or not.
Therefore, I don't have the `$hasRelated` as inline condition in the template.

**Update the post front matter**

Lastly you need to add the `related_slugs` front matter to each post that you want to be related to.

Example from this exact post:

```diff
---
extends: _layouts.post
section: content
title: Jigsaw - Related articles
date: 2026-01-26
description: Jigsaw - Related articles
cover_image: /assets/img/posts/jigsaw-related-articles.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@theshubhamdhage?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Shubham Dhage</a> on <a href="https://unsplash.com/photos/a-group-of-cubes-that-are-on-a-black-surface-T9rKvI3N0NM?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'A grid of cubes connected by wires'
featured: true
categories: [development,blog]
+related_slugs:
+  - setting-up-a-blog-with-jigsaw
---
```