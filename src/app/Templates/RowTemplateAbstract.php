<?php

namespace Novius\Backpack\VisualComposer\Templates;

use Novius\Backpack\VisualComposer\Models\VisualComposerRow;

abstract class RowTemplateAbstract
{
    static public $name = 'Unknown row type';
    static public $description = 'This row type doesn’t have a description attached';

    static public function renderCrud($model = null)
    {
        $model = $model ?: VisualComposerRow::dummy(get_called_class());

        return view(
            'visualcomposer::templates.'.class_basename(get_called_class()).'.crud',
            ['template' => get_called_class(),]
        );
    }

    static public function renderFront($model = null)
    {
        $model = $model ?: VisualComposerRow::dummy(get_called_class());

        return view(
            'visualcomposer::templates.'.class_basename(get_called_class()).'.front',
            ['content' => $model->content,]
        );
    }
}
