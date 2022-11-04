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
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();

            $table->string('descricao');
            $table->string('placa');
            $table->integer('ano_modelo');
            $table->integer('ano_fabricacao');

            $table->foreignId('categoria_habilitacaos_id')->constrained('categoria_habilitacaos');
            $table->foreignId('instrutor_id')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
};
