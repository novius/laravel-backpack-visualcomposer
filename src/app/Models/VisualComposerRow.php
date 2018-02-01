<?php

namespace Novius\Backpack\VisualComposer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class VisualComposerRow
 *
 * @method static VisualComposerRow find(integer $id)
 * @property string model_class
 * @property integer model_id
 * @property integer order
 * @property string template_class
 * @property object content
 */
class VisualComposerRow extends Model
{
    protected $table = 'visualcomposer_row';

    /**
     * Make quick empty model instance, just for show
     *
     * @param string $template
     * @return VisualComposerRow
     */
    public static function dummy($template)
    {
        $dummy = new self;
        $dummy->template_class = $template;
        return $dummy;
    }

    // TODO: Use Eloquent Polymorphic Relations
    function getResourceOwner()
    {
        if (!is_subclass_of($this->model_class, Model::class)) {
            return null;
        }

        return $this->model_class::find($this->model_id);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(
            'order',
            function (Builder $builder) {
                $builder->orderBy('visualcomposer_row.order', 'asc');
            }
        );
    }
}
