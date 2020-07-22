<?php

namespace Eav\Api\Http\Resources;

use ApiHelper\Http\Resources\Json\Resource;

class EntityValue extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $the_deets = ['type' => $this->entityCode(),
            'id'            => (string) $this->getKey(),
            'owner'         => $this->owner,
            'attributes'    => $this->getAttributes()];
        return [
            $the_deets
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('api.eav.entity.get', $this->code()),
            ],
            'meta' => [
                'attributes' => route('api.eav.attribute.list', $this->code())
            ]
        ];
    }
}
