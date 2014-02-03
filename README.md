# Fastc #

A light layer on top of Guzzle service descriptions that enables fast HTTP client development.

## Requirements ##

* PHP >= 5.4

## Installation ##

The recommended way to install is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "ebidtech/fastc": "@stable"
    }
}
```

**Tip:** browse [`ebidtech/fastc`](https://packagist.org/packages/ebidtech/fastc) page to choose a stable version to use, avoid the `@stable` meta constraint.

And run these two commands to install it:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ composer install
```

Now you can add the autoloader, and you will have access to the library:

```php
<?php

require 'vendor/autoload.php';
```

## Usage ##

## Contributing ##

See CONTRIBUTING file.

## Credits ##

* Ebidtech developer team, Fastc Lead developer [Eduardo Oliveira](https://github.com/entering) (eduardo.oliveira@ebidtech.com).
* [All contributors](https://github.com/ebidtech/fastc/contributors)

## License ##

Fastc library is released under the MIT License. See the bundled LICENSE file for details.

