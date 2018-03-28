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
        // (optionnal) Only those template will be available
        'templates' => [
            MyNewRowTemplate::class,
        ],
        // (Optionnal) Pre-fill the visualcomposer with rows on new models
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

```php?start_inline=1
@foreach($page->visualcomposer_main as $row)
    {!! $row->template::renderFront($row) !!}
@endforeach
```

## Create new row templates

Make a class and a folder for the views:

```bash
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
