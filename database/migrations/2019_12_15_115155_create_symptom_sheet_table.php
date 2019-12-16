<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSymptomSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symptom_sheet', function (Blueprint $table) {
            $table->bigInteger('sheet_id')->unsigned()->nullable();
            $table->foreign('sheet_id')->references('id')->on('receivingsheets')->onDelete('cascade');
            $table->bigInteger('symptom_id')->unsigned()->nullable();
            $table->foreign('symptom_id')->references('id')->on('symptoms')->onDelete('cascade');
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
        Schema::dropIfExists('symptom_sheet');
    }
}
