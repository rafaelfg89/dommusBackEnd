<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reajuste extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_reajuste', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_unidade');
            $table->foreign('id_unidade')->references('id')->on('unidade');
            $table->decimal('valor_reajuste');
            $table->decimal('valor_antigo');
            $table->decimal('percentual');
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
        Schema::dropIfExists('log_reajuste');
    }
}
