Url Shortener Application [Symfony]
==================================

The "Url Shortener Application" is a [URL shortening web service][1]. It helps customers by providing short version of the URL and redirects to the original URL.

Requirements
------------

  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [Symfony application requirements][2].

Installation
------------

Execute this command to install the project:

```bash
cd url-shortener/
$ composer install
```

Usage
-----

Run the built-in web server and access the application in your browser at <http://localhost:8000>:

```bash
$ cd url-shortener/
$ php bin/console server:run
```

Tests
-----

Execute this command to run tests:

```bash
$ cd url-shortener/
$ ./vendor/bin/simple-phpunit
```

[1]: https://en.wikipedia.org/wiki/URL_shortening
[2]: https://symfony.com/doc/current/reference/requirements.html
