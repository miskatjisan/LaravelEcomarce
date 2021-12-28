<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();


            $table->string('testimonial_name_en');
            $table->string('testimonial_name_others');
            $table->string('testimonial_des_en');
            $table->string('testimonial_des_others');
            $table->string('testimonial_image');
            $table->string('testimonial_position_en');
            $table->string('testimonial_position_others');



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
        Schema::dropIfExists('testimonials');
    }
}
