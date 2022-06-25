# Nova Total Card

A Laravel Nova card that displays the total number of records for a specific model, or the number of records that matches a condition.

[//]: # (<p style="text-align: center;" align="center">&#41;)

[//]: # (    <img alt="Laravel Last-Modified" src="https://github.com/abordage/nova-total-card/blob/master/docs/images/abordage-nova-total-card-screenshot.png?raw=true">)

[//]: # (</p>)

[//]: # ()
[//]: # ()
[//]: # (<p style="text-align: center;" align="center">)

[//]: # ()
[//]: # (<a href="https://packagist.org/packages/abordage/nova-total-card" title="Packagist version">)

[//]: # (    <img alt="Packagist Version" src="https://img.shields.io/packagist/v/abordage/nova-total-card">)

[//]: # (</a>)

[//]: # ()
[//]: # (<a href="https://github.com/abordage/nova-total-card/actions/workflows/tests.yml" title="GitHub Tests Status">)

[//]: # (    <img alt="GitHub Tests Status" src="https://img.shields.io/github/workflow/status/abordage/nova-total-card/Tests?label=tests">)

[//]: # (</a>)

[//]: # ()
[//]: # (<a href="https://github.com/abordage/nova-total-card/actions/workflows/php-cs-fixer.yml" title="GitHub Code Style Status">)

[//]: # (    <img alt="GitHub Code Style Status" src="https://img.shields.io/github/workflow/status/abordage/nova-total-card/PHP%20CS%20Fixer?label=code%20style">)

[//]: # (</a>)

[//]: # ()
[//]: # (<a href="https://www.php.net/" title="PHP version">)

[//]: # (    <img alt="PHP Version Support" src="https://img.shields.io/packagist/php-v/abordage/nova-total-card">)

[//]: # (</a>)

[//]: # ()
[//]: # (<a href="https://github.com/abordage/nova-total-card/blob/master/LICENSE.md" title="License">)

[//]: # (    <img alt="License" src="https://img.shields.io/github/license/abordage/nova-total-card">)

[//]: # (</a>)

[//]: # ()
[//]: # (</p>)

## Requirements
- PHP 7.4 or higher
- Nova 4

## Installation

You can install the package via composer:

```bash
composer require abordage/nova-total-card
```

## Usage

To add this card to the dashboard or resource add it to the `cards` method like this:

```php
namespace App\Nova\Dashboards;

use Abordage\TotalCard\TotalCard;
use Laravel\Nova\Dashboard;

class Main extends Dashboard
{
    public function cards(): array
    {
        $cards = [
            new TotalCard(\App\Models\User::class),
            
            /* with custom title */
            new TotalCard(\App\Models\User::class, 'All users'),
            
            /* with cache expiry time */
            new TotalCard(\App\Models\User::class, 'All users',  now()->addHour()),
            
            /* with condition */
            new TotalCard(\App\Models\User::where('is_active', 1), 'Active users',  now()->addHour()),
        ];
    }
}
```

## Feedback
If you have any feedback, comments or suggestions, please feel free to open an issue within this repository.

## Credits

- [Pavel Bychko](https://github.com/abordage)
- [All Contributors](../../contributors)

## Thanks to
The original idea comes from the [total-records](https://github.com/techouse/total-records), so many thanks to its author and contributors!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
