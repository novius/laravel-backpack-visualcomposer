<?php

namespace Novius\Backpack\VisualComposer\Traits;

use Illuminate\Database\Eloquent\Model;
use Novius\Backpack\VisualComposer\Models\VisualComposerRow;

/**
 * Trait VisualComposer
 *
 * @property VisualComposerRow[] $visualComposerRows
 */
trait VisualComposer
{
    /**
     * Return collection of rows related to the model
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getVisualcomposerRowsAttribute()
    {
        return $this->hasMany(VisualComposerRow::class, 'model_id')
            ->where('model_class', get_class());
    }
}
