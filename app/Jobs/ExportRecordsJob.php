<?php

namespace App\Jobs;

use App\Exports\RecordExport;
use App\Mail\ExportReadyMail;
use App\Models\Export;
use App\Models\Record;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExportRecordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        $fileName = 'records_' . now()->format('Y_m_d_H_i_s') . '.csv';
        $filePath = 'exports/' . $fileName;

        Storage::disk('public')->makeDirectory('exports');

        $writer = SimpleExcelWriter::create(Storage::disk('public')->path($filePath));

        $writer->addRow([
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
            'Free Ship Items',
        ]);

        Record::query()
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
            ])
            ->chunkById(5000, function ($records) use ($writer) {
                foreach ($records as $record) {
                    $writer->addRow([
                        $record->id,
                        $record->source_name,
                        $record->product_id,
                        $record->variant_id,
                        $record->handle,
                        $record->title,
                        $record->barcode,
                        $record->option1_value,
                        $record->option2_value,
                        $record->option3_value,
                        $record->variant_sku,
                        $record->variant_grams,
                        $record->vendor,
                        $record->product_type,
                        $record->status,
                        $record->tags,
                        $record->quote_method,
                        $record->freight_class,
                        $record->nmfc,
                        $record->weight,
                        $record->length,
                        $record->width,
                        $record->height,
                        $record->dropship_nickname,
                        $record->dropship_zipcode,
                        $record->dropship_city,
                        $record->dropship_state,
                        $record->dropship_country,
                        $record->hazmat,
                        $record->markup,
                        $record->boxing_properties,
                        $record->pallet_properties,
                        $record->nested_item,
                        $record->nested_dimension,
                        $record->nesting_percentage,
                        $record->maximum_nested_items,
                        $record->stacking_property,
                        $record->fulfillment_offset_days,
                        $record->handling_unit_weight,
                        $record->maximum_weight_per_handling_unit,
                        $record->insurance,
                        $record->free_ship_items,
                    ]);
                }
            });

        dispatch(new NotifyExportReadyJob($this->email, $filePath));
    }

    public function failed(\Throwable $exception)
    {
        Log::error('ExportRecordsJob failed: ' . $exception->getMessage());
    }
}
