# Visual Composer for Backpack

## Installation

```sh
composer require novius/laravel-backpack-visualcomposer
```

Then add this to `config/app.php`:

```php
Novius\Backpack\VisualComposer\VisualComposerServiceProvider::class
```

Finally, run:

```bash
php artisan vendor:publish --provider="Novius\Backpack\VisualComposer\VisualComposerServiceProvider"
php artisan migrate
```
