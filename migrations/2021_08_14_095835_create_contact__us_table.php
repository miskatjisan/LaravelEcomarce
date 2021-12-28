<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact__us', function (Blueprint $table) {
            $table->id();

            $table->unSignedBigInteger('user_id')->unsigned();
            
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade'); 
            $table->string('name');
            $table->string('email');
            $table->string('title');
            $table->text('comment');


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
        Schema::dropIfExists('contact__us');
    }
}
