<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extended_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('data_extendable_id');
            $table->string('data_extendable_type');

            $table->dateTime('datetime_01')->nullable();

            $table->string('helper');
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
        Schema::drop('extended_datas');
    }
}