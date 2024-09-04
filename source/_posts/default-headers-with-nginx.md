---
extends: _layouts.post
section: content
title: Set default headers with Nginx
date: 2021-10-21
description: Set default headers with Nginx
cover_image: /assets/img/posts/nginx-headers.jpg
cover_credit: 'Photo by <a href="https://unsplash.com/@carlheyerdahl?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Carl Heyerdahl</a> on <a href="https://unsplash.com/s/photos/website?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>'
cover_alt: 'Office desk with iMac'
featured: true
categories: [devops]
---

Working with web-development, one need to take `HTTP Headers` into consideration to. Not every web-application sets the headers that could help on security.

One of the headers is `X-Frame-Option`:

> The X-Frame-Options HTTP response header can be used to indicate whether or not a browser should be
> allowed to render a page in a `<frame>`, `<iframe>`, `<embed>` or `<object>`. Sites can use this to avoid
> click-jacking attacks, by ensuring that their content is not embedded into other sites.
>
> Source: [https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options)

**So How to set a Default with Nginx?**

In you `site`-configuration in Nginx, you can do as follows:

```apacheconf
map $upstream_http_x_frame_options $frame_option {
  '' SAMEORIGIN;
}

server {
    location ~ \.php$ {
        add_header X-Frame-Options $frame_option;
    }
}
```

This is just a very simplified example with basic configuration missing, but I hope you get the point.

Just before the server declaration, you can use the `map`-function from nginx. This maps the
value of `$upstream_http_xframe_options` to `$frame_option`, if the value is empty it's set to `SAMEORIGIN`.

This enables us in the `add_header X-Frame-Options $frame_option;` line to have either the header already set from the
application, or the default, set by Nginx.

The application could be as simple a one `PHP` file

```php 
<?php
header('X-Frame-Options: DENY');
echo "Hello, World!";
```

With the `PHP` file setting the header to `X-Frame-Options: DENY` Nginx will let the header stay as is.

**Conclusion**

I believe that it's the responsibility of the application to set the correct `Headers`, but I think it can be helpful
on server level to set a default, that catches potential security issues, if not set.
