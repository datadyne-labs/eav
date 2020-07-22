<?php

namespace Eav;

use Eav\Attribute\Option\Collection;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    /**
     * @{inheriteDoc}
     */
    protected $primaryKey = 'option_id';
    
    /**
     * @{inheriteDoc}
     */
    public $timestamps = false;
    
    /**
     * @{inheriteDoc}
     */
    protected $fillable = [
        'attribute_id', 'label', 'value', 'sort_order'
    ];
    
    /**
     * Add options for the attribute.
     *
     * @param Attribute $attribute
     * @param array     $options
     *
     * @return void
     */
    public static function add(Attribute $attribute, array $options)
    {

        foreach ($options as $value => $label) {
            if (is_array($label)){
                $customOptions = $label; // convert to be easier to read
                if (array_key_exists('label', $customOptions) &&
                    array_key_exists('value', $customOptions)) // only continue if we have the min required
                {
                    $option = static::create([
                        'attribute_id' => $attribute->attribute_id,
                        'label' => $customOptions['label'],
                        'value' => $customOptions['value'],
                        'sort_order' => $customOptions['sort_order'] ?? 0,
                    ]);
                }
            }else{
                $option = static::create([
                    'attribute_id' => $attribute->attribute_id,
                    'label' => $label,
                    'value' => $value,
                    'sort_order' => 0,
                ]);
            }

        }
    }

    /**
     * Remove options for the attribute.
     *
     * @param Attribute $attribute
     * @param array     $options
     *
     * @return void
     */
    public static function remove(Attribute $attribute, array $options)
    {
        $instance = new static;
        
        foreach ($options as $value => $label) {
            $instance->where([
                'attribute_id' => $attribute->attribute_id,
                'label' => $label,
                'value' => $value
            ])->delete();
        }
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }
}
