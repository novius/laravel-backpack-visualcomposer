<?php

namespace Novius\Backpack\VisualComposer\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rows()
    {
        return $this->hasMany(VisualComposerRow::class, 'model_id')
            ->where('model_class', get_class());
    }

    /**
     * Return collection of rows related to the model
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getVisualComposerRowsAttribute()
    {
        return $this->rows->map(function($row) {
            return (object) [
                'template' => $row->template_class,
                'content' => $row->content,
            ];
        });
    }

    public function setVisualComposerRowsAttribute($value)
    {
        $this->deleteAllRows();
        foreach (json_decode($value) as $i => $row) {
            $this->addRow($row, $i);
        }
    }

    public function addRow($row, $order)
    {
        $vcr = new VisualComposerRow();
        $vcr->model_class = get_class();
        $vcr->model_id = $this->id;
        $vcr->order = $order;
        $vcr->template_class = $row->template;
        $vcr->content = $row->content;
        $vcr->save();
    }

    public function deleteAllRows()
    {
        foreach ($this->rows as $row) {
            $row->delete();
        }
    }
}
