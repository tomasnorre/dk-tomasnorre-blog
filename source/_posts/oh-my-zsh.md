---
extends: _layouts.post
section: content
title: Oh My Zsh
date: 2026-01-18
description: How to set up Oh My Zsh
cover_image: /assets/img/posts/oh-my-zsh.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@afgprogrammer?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Mohammad Rahmani</a> on <a href="https://unsplash.com/photos/black-laptop-computer-turned-on-displaying-blue-screen-CygdSoUmmqg?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Laptop with editor and oh my zsh open'
featured: true
categories: [linux,ubuntu,arch,cachyos,debian]
---

I have for as long as I can remember been using ZSH as shell for my Linux installations. I haven't found anything that I like more till this date.
I have never come across a Linux or BSD distribution where [Oh My Zsh](https://ohmyz.sh/) didn't work.

**Prerequisites**

* git
* zsh
* curl or wget, my example is with curl, as that's my preferred

You can install the dependencies with you package manager

```bash
sudo pacman -S git zsh curl # arch based distros
sudo apt install git zsh curl # debian based distros
```

** Set you default shell**

```bash 
chsh -s /bin/zsh
```

You might how to logout and back in to have changes take effect. Something restarting the shell is enough.

** Install Oh My Zsh

``` 
sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
```

Follow the instructions from script.

Now you are ready to take benefits of Oh My Zsh.

**Additional setup**

I have some additional steps that I take. I have two plugins for Oh My Zsh that I really love.
One being [Zsh-z](https://github.com/agkozak/zsh-z) and the other [zsh-autosuggestions](https://github.com/zsh-users/zsh-autosuggestions)

Zsh-Z makes navigating between directories an ease. Zsh-autosuggestions make command suggestions based on you shell history, 
it same quite some keystrokes for me.

They are luckily quite easy to install simply use git.

```bash 
git clone https://github.com/agkozak/zsh-z ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-z
git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions
```

You would now need to edit your `~/.zshrc` find the plugins section and add the to plugins

```
plugins=( 
    # other plugins...
    zsh-z
    zsh-autosuggestions
)
```

**Starship.rs** 

Lastly I really love the look and feel of the [Starship.rs](https://starship.rs/)-prompt which will shine up your shell a bit.

To install it

```bash
curl -sS https://starship.rs/install.sh | sh
```
follow the instructions on screen.

Now add the following to your `~/.zshrc'

```bash
eval "$(starship init zsh)"
```

You can fetch my starship.rs configuration here [https://github.com/tomasnorre/dotfiles/](https://github.com/tomasnorre/dotfiles/) especially the two files

* [https://github.com/tomasnorre/dotfiles/blob/main/files/.zsh/starship.zsh](https://github.com/tomasnorre/dotfiles/blob/main/files/.zsh/starship.zsh)
* [https://github.com/tomasnorre/dotfiles/blob/main/files/.config/starship.toml](https://github.com/tomasnorre/dotfiles/blob/main/files/.config/starship.toml) 

Now you have a easy to setup and easier to use Linux shell.