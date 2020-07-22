<?php

namespace Eav\Api\Http\Resources;

use ApiHelper\Http\Resources\Json\Resource;

class Attribute extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'type'          => 'attribute',
            'id'            => (string) $this->attributeId(),
        ];
        $attribute = [
            'attribute_code'            => $this->code(),
            'entity_code'               => $request->route('code')??$request->route('entityCode'),
            'backend_class'             => $this->backend_class,
            'backend_type'              => $this->backend_type,
            'backend_table'             => $this->backend_table,
            'frontend_class'            => $this->frontend_class,
            'frontend_type'             => $this->frontend_type,
            'frontend_label'            => $this->frontend_label,
            'source_class'              => $this->source_class,
            'default_value'             => $this->default_value,
            'is_required'               => $this->is_required,
            'is_filterable'             => $this->is_filterable,
            'is_searchable'             => $this->is_searchable,
            'required_validate_class'   => $this->required_validate_class,
            'description'               => $this->description,
            'sequence'                  => $this->when(!is_null($this->sequence), $this->sequence),
            'owner'                     => $this->owner,
        ];
        $response['attribute'] = $attribute;
        if ($this->frontend_type === 'select'){
            $response['options'] = $this->optionDetails();
            return $response;
        }
        return $response;
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('api.eav.attribute.get', [$request->route('code'), $this->attributeId()]),
            ],
        ];
    }
}
