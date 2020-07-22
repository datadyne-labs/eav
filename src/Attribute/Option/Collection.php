<?php

namespace Eav\Attribute\Option;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection as BaseCollection;
use function GuzzleHttp\Psr7\_parse_request_uri;

class Collection extends BaseCollection
{
    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toOptions()
    {
        return array_reduce($this->items, function ($result, $item) {
            $result[$item->value] = $item->label;
            return $result;
        }, array());
    }

    public function toOptionDetails()
    {
        $details=[];
        foreach ($this->items as $item){
            $details[] = [
                'id' => $item->getKey(),
                'value' => $item->value,
                'label' => $item->label,
                'sort_order' => $item->sort_order,
            ];
        }
        if (count($details)>0){
            return $details;
        }
        return null;
    }

}
