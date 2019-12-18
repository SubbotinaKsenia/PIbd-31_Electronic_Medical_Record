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
        Schema::create('receiving_sheet_symptom', function (Blueprint $table) {
            $table->bigInteger('receiving_sheet_id')->unsigned()->nullable();
            $table->foreign('receiving_sheet_id')->references('id')->on('receiving_sheets')->onDelete('cascade');
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
        Schema::dropIfExists('receiving_sheet_symptom');
    }
}
