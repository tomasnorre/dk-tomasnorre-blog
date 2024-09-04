---
extends: _layouts.post
section: content
title: Setting up a blog with Jigsaw
date: 2021-07-28
description: How to set up a simple blog
cover_image: /assets/img/posts/setting-up-a-blog-with-jigsaw.jpg
cover_credit: 'Photo by <a href="https://unsplash.com/@ashkfor121?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Ashkan Forouzani</a> on <a href="https://unsplash.com/s/photos/jigsaw?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Painted jigsaw'
featured: false
categories: [blog,development]
---

With the blog post you will learn how to set up you own blog with [Jigsaw](https://jigsaw.tighten.co/).

### Prerequisites:

    * PHP 7.4+
    * composer

### Let us get started
open your terminal, and type in

```shell
$ composer require tightenco/jigsaw
$ ./vendor/bin/jigsaw init blog
```

And that's it for now.

### Watch the result
Now you can watch you blog
```shell
$ ./vendor/bin/jigsaw serve
```

Now go to [http://localhost:8000](http://localhost:8000) and you will see the demo blog from Tighten.

There are a few things that you should pay attention to. Bellow there a snippet of some of the directories.

Every category you want on your blog, you need a markdown file in your `_categories`-folder. The Layouts are all stored in the `_layouts`-folder, and last but not least, the blog posts itself are located in `_posts`-folder.

```shell
── _categories
│   ├── configuration.md
│   └── feature.md
├── _layouts
│   ├── category.blade.php
│   ├── main.blade.php
│   ├── master.blade.php
│   ├── post.blade.php
│   └── rss.blade.php
└── _posts
    ├── custom-404-page.md
    ├── customizing-your-site.md
    ├── fuse-search.md
    ├── getting-started.md
    ├── mailchimp-newsletters.md
    └── my-first-blog-post.md
```

The blog posts have a structure like

```markdown
---
extends: _layouts.post
section: content
title: My First Blog Post
date: 2017-03-23
description: This is your first blog post.
cover_image: /assets/img/post-cover-image-2.png
---

This is the start of your first blog post.

```

The section between the `---` is the metadata which all can be reached within the template (`_layouts/post.blade.php`) by using `$page->title` or `$page->date`.  The part after the `---` is simple markdown and your blog post, the `<h1>` will, with the default template, be rendered from the `title` so you would not need to add a `# Headline` yourself.

The filename in this case `my-first-blog-post.md`, will also be the URL of the post e.g. [http://localhost:8000/blog/my-first-blog-post](http://localhost:8000/blog/my-first-blog-post)

### And now?

Now you are ready to start tweaking the setup to fit your needs. Instead of using the `./vendor/bin/jigsaw serve` you can also use `npm run watch` which will start a browser with hot-reload on changes, so that you will not need to refresh your browser on every change.

*Disclaimer:*

If adding a new blog-post you would need to restart the `jigsaw serve` or `npm run watch` otherwise it will not detect the new file.

### Deployment

For deploying your new blog, I recommend looking at the [Jigsaw Documentation](https://jigsaw.tighten.co/docs/deploying-your-site/), to find the one matching your needs. I'm deploying my blog with [netlify](https://www.netlify.com/).

### Conclusion

I think I have till this day not worked with a blog system that was easier to get started with than [Jigsaw](https://jigsaw.tighten.co/), I really enjoy working with it, and it got me started really fast.