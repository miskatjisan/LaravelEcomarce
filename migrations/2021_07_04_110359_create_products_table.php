<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->integer('brand_id');
            $table->integer('Category_id');
            $table->integer('subcategory_id')->nullable();
            $table->integer('sub_subcategory_id')->nullable();
            $table->string('product_name_en');
            $table->string('product_name_others');
            $table->string('product_slug_en');
            $table->string('product_slug_others');
            $table->string('product_qty_en');
            $table->string('product_qty_others')->nullable();
            $table->string('product_code_en');
            $table->string('product_code_others')->nullable();
            $table->string('product_tags_en');
            $table->string('product_tags_others');
            $table->string('product_size_en')->nullable();
            $table->string('product_size_others')->nullable();
            $table->string('product_color_en');
            $table->string('product_color_others')->nullable();
            $table->string('selling_price_en');
            $table->string('selling_price_others')->nullable();
            $table->string('discount_price_en')->nullable();
            $table->string('discount_price_others')->nullable();
            $table->string('short_descp_en');
            $table->string('short_descp_others');
            $table->text('long_descp_en');
            $table->text('long_descp_others');
            $table->string('product_thambnail');
            $table->integer('hot_deal')->nullable();
            $table->integer('featured')->nullable();
            $table->integer('special_offer')->nullable();
            $table->integer('special_deals')->nullable();

            $table->integer('new_product')->nullable();
            $table->integer('beat_seller')->nullable();
            $table->integer('new_arrivals')->nullable();

            $table->integer('status')->default(0);
        



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
