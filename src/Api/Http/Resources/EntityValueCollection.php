<?php

namespace Eav\Api\Http\Resources;

use ApiHelper\Http\Resources\Json\ResourceCollection;

class EntityValueCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => parent::toArray($request),
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'attributes' => route('api.eav.attribute.list', $request->route('entityCode'))
            ],
        ];
    }
}
