<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseaseSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_receiving_sheet', function (Blueprint $table) {
            $table->bigInteger('receiving_sheet_id')->unsigned()->nullable();
            $table->foreign('receiving_sheet_id')->references('id')->on('receiving_sheets')->onDelete('cascade');
            $table->bigInteger('disease_id')->unsigned()->nullable();
            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
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
        Schema::dropIfExists('disease_receiving_sheet');
    }
}
