---
extends: _layouts.post
section: content
title: Simple backups with Restic
date: 2026-11-06
description: How I use Restic to take encrypted, incremental backups of my servers
cover_image: /assets/img/posts/backup-with-restic.webp
cover_credit: 'Photo by <a href="https://unsplash.com/@redaquamedia?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Denny Müller</a> on <a href="https://unsplash.com/photos/white-and-silver-hard-disk-drive-1qL31aacAPA?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Close up of an computer harddisk'
featured: true
categories: [devops, linux, opensource]
---

Self-hosting is fun, until something breaks, and you realise you don't have a backup. I have been there, and I didn't like it at all.

Today I use [Restic](https://restic.net/) for my backups. I like it for the following reasons

- backups are encrypted by default
- they are incremental, so only changes are stored
- it works with many storage backends, e.g. SFTP, S3 and local disks

**Install Restic**

Restic is available in most package managers.

```bash
sudo pacman -S restic # arch based distros
sudo apt install restic # debian based distros
```

**Create a repository**

First you need a place to store your backups, called a repository. In this example I'm using SFTP, but you can use a local folder if you want to test it first.

```bash
restic -r sftp:<user>@<host>:/backups/myserver init
```

It will prompt you for a password. Keep it somewhere safe, without it your backups are worthless.

**Take your first backup**

```bash
restic -r sftp:<user>@<host>:/backups/myserver backup /home/<user>/data
```

The first backup takes the longest, as everything needs to be uploaded. The next ones are a lot faster.

You can see your backups with

```bash
restic -r sftp:<user>@<host>:/backups/myserver snapshots
```

Will output something similar to this
```bash
$ restic -r sftp:tomas@192.168.10.81:/backups/myserver snapshots                  
enter password for repository: <type-the-password>
repository a91f26e2 opened (version 2, compression level auto)
ID        Time                 Host           Tags        Paths                 Size
-----------------------------------------------------------------------------------------
0db8873b  2026-11-06 16:20:55  restic-client              /home/tomas/dotfiles  2.608 MiB
-----------------------------------------------------------------------------------------
1 snapshots
```

**Don't type the password every time**

To make it work in a cron job or a systemd timer, you need to supply the password and the repository without prompting. This can be done with environment variables.

```bash
export RESTIC_REPOSITORY="sftp:<user>@<host>:/backups/myserver"
export RESTIC_PASSWORD_FILE="/root/.restic-password"
```

Remember to set the permissions on the password file, so only root can read it.

```bash
chmod 600 /root/.restic-password
```

How you can run restic commands like `restic snapshots` and `restic backup /home/tomas/dotfiles` without the repository nor password everytime.

## A simple script

I have put it together in a small script.

```bash
#!/usr/bin/env bash
set -e

export RESTIC_REPOSITORY="sftp:<user>@<host>:/backups/myserver"
export RESTIC_PASSWORD_FILE="/root/.restic-password"

restic backup /home/<user>/data /etc
restic forget --keep-daily 7 --keep-weekly 4 --keep-monthly 6 --prune
```

The `forget` command removes old snapshots, so you only keep the last 7 daily, 4 weekly and 6 monthly ones. Adjust it to your needs.

After the script has run the first time, my snapshots looks like this, as you can see, you can see which paths is in each snapshot, so you know which to restore.

```bash 
restic snapshots                                
repository a91f26e2 opened (version 2, compression level auto)
ID        Time                 Host           Tags        Paths                 Size
-----------------------------------------------------------------------------------------
0db8873b  2026-11-06 16:20:55  restic-client              /home/tomas/dotfiles  2.608 MiB

79402b75  2026-11-06 16:32:16  restic-client              /home/tomas/dotfiles  2.609 MiB

1ee42f25  2026-11-06 16:32:57  restic-client              /home/tomas/dotfiles  2.609 MiB

b1376a9d  2026-11-06 16:37:38  restic-client              /etc                  5.440 MiB
                                                          /home/tomas/dotfiles
-----------------------------------------------------------------------------------------
4 snapshots
```

**Automation with cron** 

Then I let `cron` run it every night.

```bash
0 2 * * * /usr/local/bin/backup.sh
```

**Test your restore**

A backup you have never restored is just a hope. So please test it.

```bash
restic restore latest --target /tmp/restore-test
```

Check that the files are there, and that they look like you expect.

This is a cut version of how my restored data looks like from the example.

```bash 
cd /tmp/restore-test 
tree .
.
└── home
    └── tomas
        └── dotfiles
            ├── CODE_OF_CONDUCT.md
            ├── LICENSE
            ├── README.md
            ├── dotbot
            │   ├── CHANGELOG.md
            │   ├── CONTRIBUTING.md
            │   ├── LICENSE.md
            │   ├── README.md
```

**Conclusion**

Restic is easy to set up, and once it is running, I don't have to think about it. Take the time to set up your backups now, you will be happy that you did, when you need them.

Have fun and store your data somewhere safe.
