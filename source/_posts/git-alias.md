---
extends: _layouts.post
section: content
title: Git Alias
date: 2025-02-03
description: How to setup a Git Wip alias
cover_image: /assets/img/posts/git-alias.jpg
cover_credit: 'Photo by <a href="https://unsplash.com/@yancymin?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Yancy Min</a> on <a href="https://unsplash.com/photos/a-close-up-of-a-text-description-on-a-computer-screen-842ofHC6MaI?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'Screenshot of a gitlog'
featured: true
categories: [development,devops]
---

Git is an amazing tool, I personally use a `git wip` alias all the time, which gives a nice overview of which branches have been worked on lately.

```bash
$ git wip
  6 months ago	ci-phpstan-fix
  4 months ago	bugfix/update-label
  4 days ago	v11.x
  2 days ago	main
```

You can add following to your `~/.gitconfig` save and volá you're done, and ready to use it.

```ini
[alias]
  wip = for-each-ref --sort='authordate:iso8601' --format=' %(color:green)%(authordate:relative)%09%(color:white)%(refname:short)' refs/heads
```


