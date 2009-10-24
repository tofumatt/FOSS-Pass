# FOSS Pass #
## Link to your license. ##

FOSS Pass allows you to link to many popular open-source licenses and even include your own info in the license text.

### Setup ###

You'll need a web server and [PHP 5](http://php.net) -- that's about it. Access to the filesystem (system/cache) for writing cache files is nice, but not required. Also, most modern web servers should work fine -- this app was developed on [Apache 2](http://httpd.apache.org) (mod_php) but [The FOSS Pass site itself](http://fosspass.org) runs on lighttpd 1.4 with PHP served through FastCGI.

You might have to change the `$config['uri_protocol']` setting in **`system/application/config/config.php`** depending on your server/PHP setup. On Apache 2 "`AUTO`" is usually fine, but on lighttpd 1.4 with FastCGI "`REQUEST_URI`" seems to be the only setting that works.

You can disable error reporting in "`index.php`" by setting `error_reporting(0)`.

There's a Google Analytics script in the end of the "`page.html`" file in **`system/application/views/`**. You should either delete the `<script>` tags altogether or change the code to your own if you deploy your own version of this app somewhere.

**A note on caching:** If you'd like the HTML of generated pages to be cached, you can set the `CACHE_EXPIRY` constant in **`system/application/config/constants.php`** to the number of minutes the HTML should be cached for. Since nothing should really change between requests you could set this pretty high if you want to improve performance a bit (caching in CodeIgniter skips all controller processing and just spits out a static HTML file). The **`system/cache/`** folder will need to be writable by your web server process.

## License ##

This program is free software; it is distributed under a [New BSD-Style License](http://fosspass.org/license/bsd?author=Matthew+Riley+MacPherson&organization=The+Lonely+Web&year=2009).

This program was built using the [CodeIgniter PHP Framework](http://codeigniter.com), which is [under its own license](http://fosspass.org/license/codeigniter). Only relevant parts of the framework are included (database and other libraries, etc. were removed).

The "Fork me on GitHub" logo is licensed under an [MIT-style license](http://fosspass.org/license/mit?author=Tom+Preston-Werner&year=2008).

---

Copyright (c) 2009 [Matthew Riley MacPherson](http://lonelyvegan.com).