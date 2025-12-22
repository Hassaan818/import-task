<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Record extends Model
{
    protected $fillable = [
        'source_name',
        'product_id',
        'variant_id',
        'handle',
        'title',
        'barcode',
        'option1_value',
        'option2_value',
        'option3_value',
        'variant_sku',
        'variant_grams',
        'vendor',
        'product_type',
        'status',
        'tags',
        'quote_method',
        'freight_class',
        'nmfc',
        'weight',
        'length',
        'width',
        'height',
        'dropship_nickname',
        'dropship_zipcode',
        'dropship_city',
        'dropship_state',
        'dropship_country',
        'hazmat',
        'markup',
        'boxing_properties',
        'pallet_properties',
        'nested_item',
        'nested_dimension',
        'nesting_percentage',
        'maximum_nested_items',
        'stacking_property',
        'fulfillment_offset_days',
        'handling_unit_weight',
        'maximum_weight_per_handling_unit',
        'insurance',
        'free_ship_items',
    ];
}
