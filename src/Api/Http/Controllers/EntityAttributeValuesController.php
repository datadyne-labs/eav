<?php

namespace Eav\Api\Http\Controllers;

use ApiHelper\Http\Resources\Json\Resource;
use ApiHelper\Http\Resources\Json\ResourceCollection;
use Eav\Api\Http\Resources\AttributeCollection;
use Eav\Api\Http\Resources\AttributeValue;
use Eav\Api\Http\Resources\EntityCollection;
use Eav\Api\Http\Resources\EntityValueCollection;
use Eav\Entity;
use Eav\Attribute as AttributeModel;
use Eav\Api\Http\Resources\Attribute;
use ApiHelper\Http\Resources\Error;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class EntityAttributeValuesController extends Controller
{

    public function list(Request $request, $entityCode)
    {
        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        $model = $class::select(['attr.*'])->with('owner');
        if ($model === null){
            throw new HttpResponseException((new Error([
                'code' => '101',
                'title' => 'Invalid Code',
                'detail' => 'Given Code does not exist.',
            ]))->response()
                ->setStatusCode(404));
        }
        
//        $attributeValues = $model->select(['attr.*'])
        $collection = new EntityValueCollection($this->paginate($model));
        $collection->additional(['meta' => ['attributes' => new AttributeCollection($entity->attributes)]]);
        return $collection;
    }

    public function get(Request $request, $entityCode, $id, $attrCode)
    {
        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        $model = $class::where('id',$id)->first();
        try {
            $attributeValues = $model::select([$attrCode])->find($model->getKey());
        }catch (\Exception $exception){
            throw new HttpResponseException((new Error([
                'code' => '101',
                'title' => 'Invalid Code',
                'detail' => 'Given Code does not exist.',
            ]))->response()
                ->setStatusCode(404));
        }


        return new AttributeValue($attributeValues);
    }

    public function create(Request $request, $code)
    {
      //
    }

    public function update(Request $request, $code, $id)
    {
       //
    }

    public function remove(Request $request, $code, $id)
    {
        //
    }

}
