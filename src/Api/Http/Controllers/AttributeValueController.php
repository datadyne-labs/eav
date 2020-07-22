<?php

namespace Eav\Api\Http\Controllers;

use ApiHelper\Http\Resources\Json\Resource;
use Eav\Api\Http\Resources\AttributeValue;
use Eav\Entity;
use Eav\Attribute as AttributeModel;
use Eav\Api\Http\Resources\Attribute;
use ApiHelper\Http\Resources\Error;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class AttributeValueController extends Controller
{

    public function list(Request $request, $entityCode, $id)
    {
        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        $model = $class::where('id',$id)->first();
        if ($model === null){
            throw new HttpResponseException((new Error([
                'code' => '101',
                'title' => 'Invalid Code',
                'detail' => 'Given Code does not exist.',
            ]))->response()
                ->setStatusCode(404));
        }
        
        $attributeValues = $model->select(['attr.*'])->find($id);

        return new Resource($attributeValues);
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
