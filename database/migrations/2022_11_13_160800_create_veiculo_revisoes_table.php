<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculo_revisoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('veiculo_id')->constrained('veiculos');
            $table->date('data_agendamento');
            $table->time('hora_agendamento');

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
        Schema::dropIfExists('veiculo_revisaos');
    }
};
