<?php

namespace Eav\Api\Http\Controllers;

use ApiHelper\Http\Resources\Json\Resource;
use Eav\Api\Http\Resources\AttributeOptions;
use Eav\Attribute;
use Illuminate\Http\Request;

class AttributeOptionsController extends Controller
{

    public function list(Request $request, $entityCode, $attrCode){
        $attribute = Attribute::findByCode($attrCode, $entityCode);

        return new AttributeOptions($attribute);
    }

    public function create(Request $request, $entityCode, $attrCode){

    }
}
