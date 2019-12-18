<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_receiving_sheet', function (Blueprint $table) {
            $table->bigInteger('receiving_sheet_id')->unsigned()->nullable();
            $table->foreign('receiving_sheet_id')->references('id')->on('receiving_sheets')->onDelete('cascade');
            $table->bigInteger('drug_id')->unsigned()->nullable();
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
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
        Schema::dropIfExists('drug_receiving_sheet');
    }
}
