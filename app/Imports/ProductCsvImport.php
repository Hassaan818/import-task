<?php

namespace App\Imports;

use App\Models\Import;
use App\Models\Record;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeImport;

class ProductCsvImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
{
    use RemembersRowNumber;

    protected $importId;

    public function __construct($importId)
    {
        $this->importId = $importId;
    }
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        Import::where('id', $this->importId)->increment('processed_rows');
        \Log::info(array_keys($row));
        return new Record([
            'source_name' => $row['sourcename'] ?? null,
            'product_id' => $row['product_id'] ?? null,
            'variant_id' => $row['variant_id'] ?? null,
            'handle' => $row['handle'] ?? null,
            'title' => $row['title'] ?? null,
            'barcode' => $row['barcode'] ?? null,
            'option1_value' => $row['option1_value'] ?? null,
            'option2_value' => $row['option2_value'] ?? null,
            'option3_value' => $row['option3_value'] ?? null,
            'variant_sku' => $row['variant_sku'] ?? null,
            'variant_grams' => $row['variant_grams'] ?? null,
            'vendor' => $row['vendor'] ?? null,
            'product_type' => $row['product_type'] ?? null,
            'status' => $row['status'] ?? null,
            'tags' => $row['tags'] ?? null,
            'quote_method' => $row['quote_method'] ?? null,
            'freight_class' => $row['freight_class'] ?? null,
            'nmfc' => $row['nmfc'] ?? null,
            'weight' => $row['weight'] ?? null,
            'length' => $row['length'] ?? null,
            'width' => $row['width'] ?? null,
            'height' => $row['height'] ?? null,
            'dropship_nickname' => $row['dropship_nickname'] ?? null,
            'dropship_zipcode' => $row['dropship_zipcode'] ?? null,
            'dropship_city' => $row['dropship_city'] ?? null,
            'dropship_state' => $row['dropship_state'] ?? null,
            'dropship_country' => $row['dropship_country'] ?? null,
            'hazmat' => $row['hazmat'] ?? null,
            'markup' => $row['markup'] ?? null,
            'boxing_properties' => $row['boxing_properties'] ?? null,
            'pallet_properties' => $row['pallet_properties'] ?? null,
            'nested_item' => $row['nested_item'] ?? null,
            'nested_dimension' => $row['nested_dimension'] ?? null,
            'nesting_percentage' => $row['nesting'] ?? null, // check key after snake conversion
            'maximum_nested_items' => $row['maximum_nested_items'] ?? null,
            'stacking_property' => $row['stacking_property'] ?? null,
            'fulfillment_offset_days' => $row['fulfillment_offset_days'] ?? null,
            'handling_unit_weight' => $row['handling_unit_weight'] ?? null,
            'maximum_weight_per_handling_unit' => $row['maximum_weight_per_handling_unit'] ?? null,
            'insurance' => $row['insurance'] ?? null,
            'free_ship_items' => $row['free_ship_items'] ?? null,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                Import::where('id', $this->importId)->update([
                    'status' => 'processing',
                ]);
            },

            AfterImport::class => function (AfterImport $event) {
                $import = Import::find($this->importId);
                $import->update([
                    'status' => 'completed',
                    'total_rows' => $import->processed_rows,
                ]);
            },
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
