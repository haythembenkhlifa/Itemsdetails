<?php

namespace Haythem\Itemsdetails;

use Illuminate\Contracts\Container\BindingResolutionException;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Itemsdetails extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'itemsdetails';


    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        logger("Row Value");
        logger($request[$requestAttribute]);
        logger("formatted Value");
        logger(json_decode($request[$requestAttribute],true));
        if ($request->exists($requestAttribute)) {
        $model->{$attribute} = json_decode($request[$requestAttribute]);
        }
    }


}
