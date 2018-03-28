<?php

namespace Novius\Backpack\VisualComposer\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Novius\Backpack\VisualComposer\Models\VisualComposerRow;

/**
 * Trait VisualComposer
 *
 * @property VisualComposerRow[] $visualComposerRows
 */
trait VisualComposer
{
    /**
     * Return a relation of rows for the model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rows()
    {
        return $this->hasMany(VisualComposerRow::class, 'model_id')
            ->where('model_class', get_class());
    }

    /**
     * Return a collection of rows for a specific field
     *
     * @param $crudfield
     * @return mixed
     */
    public function getRows($crudfield)
    {
        return $this->rows()->where('model_crudfield', $crudfield)->get();
    }

    /**
     * Set up a magic getter for visualcomposer fields
     *
     * @param string $key
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function __get($key)
    {
        $fieldPrefix = config('visualcomposer.field_prefix', 'vc_');
        if (preg_match("/^{$fieldPrefix}(.*)/", $key, $match)) {
            return $this->getVisualComposerRows($match[1]);
        }

        return $this->getAttribute($key);
    }

    /**
     * Set up a magic getter for visualcomposer fields
     *
     * @param string $key
     * @param string $value
     */
    public function __set($key, $value)
    {
        $fieldPrefix = config('visualcomposer.field_prefix', 'vc_');
        if (preg_match("/^{$fieldPrefix}(.*)/", $key, $match)) {
            return $this->setVisualComposerRows($match[1], $value);
        }

        $this->setAttribute($key, $value);
    }

    /**
     * Get a visualcomposer set of rows
     *
     * @param string field
     * @return object
     */
    public function getVisualComposerRows($crudfield)
    {
        return $this->getRows($crudfield)->map(function($row) {
            return (object) [
                'template' => $row->template_class,
                'content' => $row->content,
            ];
        });
    }

    /**
     * Set a visualcomposer field with a set of json rows
     *
     * @param string $crudfield
     * @param string $value
     */
    public function setVisualComposerRows($crudfield, $value)
    {
        try {
            // Check json beforehand
            if (!is_array(json_decode($value))) {
                throw new \Exception;
            }

            $this->deleteAllRows($crudfield);

            foreach (json_decode($value) as $i => $row) {
                $this->addRow($crudfield, $row, $i);
            }
        }
        catch(\Exception $e) {
            // Save problematic input
            Storage::append('visualcomposer/failed-rows.log', date('c').' '.$value);
        }
    }

    /**
     * Add a row to the database
     *
     * @param $crudfield
     * @param $row
     * @param $order
     */
    public function addRow($crudfield, $row, $order)
    {
        $vcr = new VisualComposerRow();
        $vcr->model_class = get_class();
        $vcr->model_id = $this->id;
        $vcr->model_crudfield = $crudfield;
        $vcr->order = $order;
        $vcr->template_class = $row->template;
        $vcr->content = $row->content;
        $vcr->save();
    }

    /**
     * Clear all rows associated with a given crudfield
     *
     * @param $crudfield
     */
    public function deleteAllRows($crudfield)
    {
        foreach ($this->getRows($crudfield) as $row) {
            $row->delete();
        }
    }
}
