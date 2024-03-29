<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('division_id')->unsigned();

            $table->unsignedDecimal('unit_price', 12, 0)->nullable();
            $table->unsignedDecimal('price', 12, 0)->nullable();
            $table->unsignedBigInteger('qty')->nullable();

            $table->text('image_url')->nullable();
            $table->timestamp('year_of_purchase')->nullable();
            $table->text('notes')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->text('barcode')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            /** Foreign Key */
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade');
    
            $table->foreign('category_id')->references('id')->on('inventory_categories')
            ->onDelete('cascade');
    
            $table->foreign('brand_id')->references('id')->on('inventory_brands')
            ->onDelete('cascade');
    
            $table->foreign('supplier_id')->references('id')->on('inventory_suppliers')
            ->onDelete('cascade');

            $table->foreign('division_id')->references('id')->on('divisions')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}
