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