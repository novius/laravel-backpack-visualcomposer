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

```PHP?start_inline=1
use Novius\Backpack\VisualComposer\Traits\VisualComposer;
```

In the crud controller:

```PHP?start_inline=1
public function setup($template_name = false)
{
    parent::setup($template_name);
    $this->crud->addField([
        'name' => 'visualComposerRows',
        'label' => 'Visual Composer',
        'type' => 'visualcomposer',
        'wrapperAttributes' => [
            'class' => 'form-group col-md-12',
        ],
    ]);
}

public function update(PageRequest $request)
{
    Page::findOrFail($request->id)->visualComposerRows = $request->visualComposerRows;
    return parent::update($request);
}
```

In the model view:

```PHP?start_inline=1
@foreach($page->visualComposerRows as $row)
    {!! $row->template::renderFront($row) !!}
@endforeach
```

## Create new line templates

Make a class and a folder for the views:

```Bash
cd vendor/novius/laravel-backpack-visualcomposer
touch src/app/Templates/MyNewRowTemplate.php
mkdir src/resources/views/vendor/visualcomposer/MyNewRowTemplate
touch src/resources/views/vendor/visualcomposer/MyNewRowTemplate/crud.blade.php
touch src/resources/views/vendor/visualcomposer/MyNewRowTemplate/front.blade.php
```

In `MyNewRowTemplate.php`:

```PHP
<?php

namespace Novius\Backpack\VisualComposer\Templates;

class MyNewRowTemplate extends RowTemplateAbstract
{
    static public $name = 'My new row template';
    static public $description = 'This is a new row template';
}
```

In `crud.blade.php`:

```HTML
<div class="row-template new-row-template">
    <input type="hidden">
    <textarea>{{ $content }}</textarea>
</div>

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function () {
            $('.vc-rows').on(
                'change blur keydown',
                '.new-row-template textarea',
                function () {
                    $(this)
                        .closest('.row-template')
                            .find('[type=hidden]').val(this.value);
                }
            );
        });
    </script>
@endpush
```

In `front.blade.php`:

```HTML
<div class="row-template new-row-template">
    <input type="hidden">
    <textarea>{{ $content }}</textarea>
</div>

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function () {
            $('.vc-rows').on(
                'change blur keydown',
                '.new-row-template textarea',
                function () {
                    $(this)
                        .closest('.row-template')
                            .find('[type=hidden]').val(this.value);
                }
            );
        });
    </script>
@endpush
```

```HTML
<div class="vc-new-row">
    {!! $content !!}
</div>
```
