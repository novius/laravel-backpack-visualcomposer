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

## Use

In the model:

```php?start_inline=1
use Novius\Backpack\VisualComposer\Traits\VisualComposer;
```

In the crud controller:

```php?start_inline=1
public function setup($template_name = false)
{
    parent::setup($template_name);

    $this->crud->addField([
        'name' => 'visualcomposer_main',
        'label' => 'Visual Composer',
        'type' => 'visualcomposer',
        //'templates' => [
        //    MyNewRowTemplate::class, // ← Only this template will be available
        //],
        'wrapperAttributes' => [
            'class' => 'form-group col-md-12',
        ],
    ]);
}

public function update(PageRequest $request)
{
    Page::findOrFail($request->id)->visualcomposer_main = $request->visualcomposer_main;

    return parent::update($request);
}
```

In the model view:

```php?start_inline=1
@foreach($page->visualcomposer_main as $row)
    {!! $row->template::renderFront($row) !!}
@endforeach
```

## Create new row templates

Make a class and a folder for the views:

```bash
cd vendor/novius/laravel-backpack-visualcomposer
touch src/app/Templates/MyNewRowTemplate.php
mkdir src/resources/views/vendor/visualcomposer/MyNewRowTemplate
touch src/resources/views/vendor/visualcomposer/MyNewRowTemplate/crud.blade.php
touch src/resources/views/vendor/visualcomposer/MyNewRowTemplate/front.blade.php
```

In `MyNewRowTemplate.php`:

```php
<?php

namespace Novius\Backpack\VisualComposer\Templates;

class MyNewRowTemplate extends RowTemplateAbstract
{
    static public $name = 'My new row template';
    static public $description = 'This is a new row template';
}
```

In `crud.blade.php`:

```php
<div class="row-template new-row-template">
    <input type="hidden">
    <textarea></textarea>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content) {
            $('textarea', $row).val(content);
            var update = function () {
                $('[type=hidden]', $row).val(this.value);
            };
            update();
            $row.on(
                'change blur keyup',
                'textarea',
                update
            );
        }
    </script>
@endpush
```
