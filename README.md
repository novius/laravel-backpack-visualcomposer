# Visual Composer for Backpack
[![Travis](https://img.shields.io/travis/novius/laravel-backpack-visualcomposer.svg?maxAge=1800&style=flat-square)](https://travis-ci.org/novius/laravel-backpack-visualcomposer)
[![Packagist Release](https://img.shields.io/packagist/v/novius/laravel-backpack-visualcomposer.svg?maxAge=1800&style=flat-square)](https://packagist.org/packages/novius/laravel-backpack-visualcomposer)
[![Licence](https://img.shields.io/packagist/l/novius/laravel-backpack-visualcomposer.svg?maxAge=1800&style=flat-square)](https://github.com/novius/laravel-backpack-visualcomposer#licence)

Improve the way you edit pages.

## Installation

```sh
composer require novius/laravel-backpack-visualcomposer
```

Then add this to `config/app.php`:

```php
Novius\Backpack\VisualComposer\VisualComposerServiceProvider::class,
```

Finally, run:

```sh
php artisan migrate
```

## Use

In the model:

```php
use \Novius\Backpack\VisualComposer\Traits\VisualComposer;
```

In the crud controller:

```php
public function setup($template_name = false)
{
    parent::setup($template_name);

    $this->crud->addField([
        'name' => 'visualcomposer_main',
        'label' => 'Visual Composer',
        'type' => 'view',
        'view'   => 'visualcomposer::visualcomposer',
        // (optionnal) Only those template will be available
        'templates' => [
            MyNewRowTemplate::class,
        ],
        // (optionnal) Pre-fill the visualcomposer with rows on new models
        'default' => [
            ['template' => MyNewRowTemplate::class],
        ],
        'wrapperAttributes' => [
            'class' => 'form-group col-md-12',
        ],
    ]);
}

public function store(PageRequest $request)
{
    $r = parent::store($request);
    $this->crud->entry->visualcomposer_main = $request->visualcomposer_main;
    return $r;
}

public function update(PageRequest $request)
{
    $r = parent::update($request);
    $this->crud->entry->visualcomposer_main = $request->visualcomposer_main;
    return $r;
}
```

In the model view:

```php
@foreach($page->visualcomposer_main as $row)
    {!! $row->template::renderFront($row) !!}
@endforeach
```

## Create new row templates

Make a class and a folder for the views:

```sh
cd vendor/novius/laravel-backpack-visualcomposer
class=MyNewRowTemplate
touch src/app/Templates/$class.php
mkdir src/resources/views/vendor/visualcomposer/$class
touch src/resources/views/vendor/visualcomposer/$class/crud.blade.php
touch src/resources/views/vendor/visualcomposer/$class/front.blade.php
```

In `MyNewRowTemplate.php`:

```php
<?php

namespace Novius\Backpack\VisualComposer\Templates;

class MyNewRowTemplate extends RowTemplateAbstract
{
    static public $name = 'my-new-row-template';
}
```

In `crud.blade.php`:

```php
<div class="row-template vc-my-new-row-template">
    <input type="hidden" class="content">
    <textarea class="some_field"
              placeholder="{{ trans('visualcomposer::my-new-row-template.crud.some_field') }}"></textarea>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var fields = [
                'some_field',
            ];

            // Setup update routine
            var update = function () {
                var contents = [];
                fields.map(function (item) {
                    contents.push($('.'+item, $row).val());
                });
                $hiddenInput.val(
                    JSON.stringify(contents)
                );
            };

            // Parse and fill fields from json passed in params
            fields.map(function (item, index) {
                try {
                    $('.'+item, $row).val(JSON.parse(content)[index]);
                } catch(e) {
                    console.log('Empty or invalid json:', content);
                }
            });

            // Update hidden field on change
            $row.on(
                'change blur keyup',
                'input, textarea, select',
                update
            );

            // Initialize hidden form input in case we submit with no change
            update();
        }
    </script>
@endpush
```

In `resources/lang/vendor/visualcomposer/en/templates.php`, add:

```php
<?php
...
    'my-new-row-template' => [
        'name' => 'My new row template',
        'crud' => [
            'some_field' => 'Some field for you to write something in',
        ],
    ],
```

## Edit default config and templates


Run:

```sh
php artisan vendor:publish --provider="Novius\Backpack\VisualComposer\VisualComposerServiceProvider"
```

...it will output the list of copied files than can now be overwritten, including the config, the backpack field type, the language files and 11 built-in templates:

- *Article*, an wysiwyg and inputs for the title, subtitle, date, author, CTA button and user-customizable colors
- *BackgroundImageAndText*, an uploadable picture with a caption and wysiwyg description
- *ImageInBase64*, a picture stored as base64 instead of file upload
- *ImageInContainer*, an uploadable picture, and that’s it
- *LeftImageRightText*, a picture and some text fields on two columns
- *LeftTextRightImage*, some text fields and a picture on two columns
- *LeftTextRightQuote*, some text fields and customizable background color, on two columns
- *Minimal*, an empty template with the minimum code for it to work
- *Slideshow*, a slider of unlimited pictures and their captions
- *ThreecolumnsImageTextCta*, three columns with a picture, a title, a wysiwyg and a CTA button on each of them
- *TwoColumnsImageTextCta*, the same as above, but on two columns instead of three

Check out how they are made, so you can customize them and build your own.
