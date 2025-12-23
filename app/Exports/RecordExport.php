<?php

namespace App\Exports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecordExport implements FromQuery, WithHeadings, WithChunkReading
{
    use Exportable;

    public function query()
    {
        return Record::query()
                    ->select([
                        'id',
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
                    ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Source Name',
            'Product ID',
            'Variant ID',
            'Handle',
            'Title',
            'Barcode',
            'Option1',
            'Option2',
            'Option3',
            'Variant SKU',
            'Variant Grams',
            'Vendor',
            'Product Type',
            'Status',
            'Tags',
            'Quote Method',
            'Freight Class',
            'NMFC',
            'Weight',
            'Length',
            'Width',
            'Height',
            'Dropship Nickname',
            'Dropship Zipcode',
            'Dropship City',
            'Dropship State',
            'Dropship Country',
            'Hazmat',
            'Markup',
            'Boxing Properties',
            'Pallet Properties',
            'Nested Item',
            'Nested Dimension',
            'Nesting %',
            'Maximum Nested Items',
            'Stacking Property',
            'Fulfillment Offset Days',
            'Handling Unit Weight',
            'Max Weight per Handling Unit',
            'Insurance',
            'Free Ship Items'
        ];
    }

    public function chunkSize(): int
    {
        return 20000;
    }
}
