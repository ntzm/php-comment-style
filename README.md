# PHP Comment Style

Formats PHP comments.

From:

```php
//foo
/*bar baz*/
```

To:

```php
// foo
/* bar baz */
```

## Installation

`composer require --dev ntzm/php-comment-style`

## Running

To fix all PHP files in `src/`:

`vendor/bin/php-comment-style fix src`

To fix all PHP files in `src/` and `tests/`:

`vendor/bin/php-comment-style fix src tests`
