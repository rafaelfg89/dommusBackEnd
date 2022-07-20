<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bloco');
            $table->foreign('id_bloco')->references('id')->on('blocos');
            $table->decimal('valor');
            $table->foreignId('id_status');
            $table->foreign('id_status')->references('id')->on('status');
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
        Schema::dropIfExists('unidade');
    }
}
