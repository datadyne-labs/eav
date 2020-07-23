<?php

namespace Eav\Api\Http\Controllers;

use ApiHelper\Http\Resources\Json\Resource;
use ApiHelper\Http\Resources\Json\ResourceCollection;
use App\Laravue\JsonResponse;
use Faker\Factory;
use Faker\Generator as Faker;
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

    public function list(Request $request, $entityCode, $id)
    {
        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        $model = $class::select(['attr.*'])->with('owner')->where('id',$id)->first();
        if ($model === null){
            throw new HttpResponseException((new Error([
                'code' => '101',
                'title' => 'Invalid Code',
                'detail' => 'Given Code does not exist.',
            ]))->response()
                ->setStatusCode(404));
        }
        
//        $attributeValues = $model->select(['attr.*'])
        $collection = new Resource($model);
//        $collection->additional(['meta' => ['attributes' => new AttributeCollection($entity->attributes)]]);
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

    public function create(Request $request, $entityCode)
    {
      //
        $faker = Factory::create();

        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        return new Resource($class::create([
            'first_name'                    => $faker->firstName,
            'email'                         => $faker->unique()->safeEmail,
            'last_name'                     => $faker->lastName,
            'lead_status'                   => $faker->randomElement([1,2,3]),
            'new'                           => $faker->boolean,
            'investable_assets'             => $faker->randomFloat(2,10000,1000000000),
            'birthday'                      => $faker->dateTimeBetween(),
            'notes'                         => $faker->realText(50),
            'phone'                         => "({$faker->randomNumber(3,true)}) {$faker->randomNumber(3,true)}-{$faker->randomNumber(4,true)}",
        ]));

    }

    public function update(Request $request, $entityCode, $id)
    {
        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        $model = $class::where('id',$id)->first();
        // TODO handle options
        $model->fill($request->all())->save();
        return new Resource($model);
    }

    public function remove(Request $request, $entityCode, $id)
    {
        $entity = $this->getEntity($entityCode);
        $class = $entity->entity_class;
        $model = $class::where('id',$id)->first();
        $model->delete();
        return new JsonResponse(200);
    }

}
