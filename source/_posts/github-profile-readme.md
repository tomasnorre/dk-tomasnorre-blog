---
extends: _layouts.post
section: content
title: GitHub Profile README
date: 2025-10-11
description: How to set up a nice GitHub Profile README
cover_image: /assets/img/posts/github-profile-readme.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@synkevych?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Roman Synkevych</a> on <a href="https://unsplash.com/photos/black-and-white-penguin-toy-wX2L8L-fGeA?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>'
cover_alt: 'GitHub Logo Figure in standing on a laptop'
featured: true
categories: [opensource]
---

GitHub have for quite some time given you the possibility to add a nice [profile on github](https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-github-profile/customizing-your-profile/managing-your-profile-readme), by creating a repository with the same name as your GitHub username, in my case
[https://github.com/tomasnorre/tomasnorre](https://github.com/tomasnorre/tomasnorre), the README.md in there will be displayed when going to [https://github.com/tomasnorre](https://github.com/tomasnorre). 

A static site is a little boring, and maintaining it manually even worse.

### Let me show how to automate this

*Disclaimer: This is heavily inspired and copied from [https://github.com/soyuka](https://github.com/soyuka)*

First you need to create the repository as mentioned above `username/username`, if in doubt see [article](https://docs.github.com/en/account-and-profile/how-tos/setting-up-and-managing-your-github-profile/customizing-your-profile/managing-your-profile-readme) on github.

Then you need to create a Person GitHub Token, and store is as a secret on the repository `username/username`. The Token should have following permissions: 

```
repo
admin:org
user
```

When the token is create save it under the repository `username/username` under the name `PERSONAL_GITHUB_TOKEN`.

#### Create the template and GitHub action

Now we need to setup the action. First we will create a template

File: `templates/README.md.tpl`
```markdown
### Hi there 👋

#### 👷 Check out what I'm currently working on
{{range recentContributions 3}}
- [{{.Repo.Name}}]({{.Repo.URL}}) - {{.Repo.Description}} ({{humanize .OccurredAt}})
{{- end}}

#### 🔭 Latest releases I've contributed to
{{range recentReleases 3}}
- [{{.Name}}]({{.URL}}) ([{{.LastRelease.TagName}}]({{.LastRelease.URL}}), {{humanize .LastRelease.PublishedAt}}) - {{.Description}}
{{- end}}

#### 📜 My recent [blog posts](https://blog.tomasnorre.dk)
{{range rss "https://blog.tomasnorre.dk/blog/feed.atom" 5}}
- [{{.Title}}]({{.URL}}) ({{humanize .PublishedAt}})
{{- end}}

#### ❤️ These awesome people [sponsor me](https://github.com/sponsors/tomasnorre) (thank you!)
{{range sponsors 3}}
- [{{.User.Login}}]({{.User.URL}}) ({{humanize .CreatedAt}})
{{- end}}

This README setup is heavily inspired and copied from https://github.com/soyuka
```

You can of course adjust it to your needs, but I like it like this. 

Now we need to create the workflow itself.

File: `.github/workflows/readme-write.yml`
```yaml
name: Update README

on:
  push:
  schedule:
    - cron: "0 */3 * * *"

jobs:
  markscribe:
    runs-on: ubuntu-latest
    permissions:
      contents: write

    steps:
      - uses: actions/checkout@v4
        with:
          ref: ${{ github.head_ref }}

      - uses: muesli/readme-scribe@master
        env:
          GITHUB_TOKEN: ${{ secrets.PERSONAL_GITHUB_TOKEN }}
        with:
          template: "templates/README.md.tpl"
          writeTo: "README.md"

      - uses: stefanzweifel/git-auto-commit-action@v5
        with:
          commit_message: Update generated README
```

This is all you would need, this will run ones every 3 hours, you can of course change this to fit your needs.

