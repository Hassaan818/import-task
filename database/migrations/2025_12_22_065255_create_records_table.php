<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('source_name')->nullable();
            $table->string('product_id')->index();
            $table->string('variant_id')->index();

            $table->string('handle')->nullable();
            $table->string('title')->nullable();
            $table->string('barcode')->nullable();

            $table->string('option1_value')->nullable();
            $table->string('option2_value')->nullable();
            $table->string('option3_value')->nullable();

            $table->string('variant_sku')->nullable();
            $table->integer('variant_grams')->nullable();

            $table->string('vendor')->nullable();
            $table->string('product_type')->nullable();
            $table->string('status')->nullable();

            $table->text('tags')->nullable();

            $table->string('quote_method')->nullable();
            $table->string('freight_class')->nullable();
            $table->string('nmfc')->nullable();

            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();

            $table->string('dropship_nickname')->nullable();
            $table->string('dropship_zipcode')->nullable();
            $table->string('dropship_city')->nullable();
            $table->string('dropship_state')->nullable();
            $table->string('dropship_country')->nullable();

            $table->boolean('hazmat')->nullable();
            $table->decimal('markup', 10, 2)->nullable();

            $table->string('boxing_properties')->nullable();
            $table->string('pallet_properties')->nullable();

            $table->boolean('nested_item')->nullable();
            $table->string('nested_dimension')->nullable();
            $table->decimal('nesting_percentage', 5, 2)->nullable();
            $table->integer('maximum_nested_items')->nullable();

            $table->string('stacking_property')->nullable();
            $table->integer('fulfillment_offset_days')->nullable();

            $table->decimal('handling_unit_weight', 10, 2)->nullable();
            $table->decimal('maximum_weight_per_handling_unit', 10, 2)->nullable();

            $table->boolean('insurance')->nullable();
            $table->boolean('free_ship_items')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
