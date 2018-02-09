<?php

return [
    // model_crudfield value prefix in database
    'field_prefix' => 'visualcomposer_',

    // Installed and available templates to show in crud
    'templates' => [
        \Novius\Backpack\VisualComposer\Templates\WideRowTemplate::class,
        \Novius\Backpack\VisualComposer\Templates\ThreeColumnsRowTemplate::class,
        \Novius\Backpack\VisualComposer\Templates\ThreeNumbersRowTemplate::class,
    ],
];
