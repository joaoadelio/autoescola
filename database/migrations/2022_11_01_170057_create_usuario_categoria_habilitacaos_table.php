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
        Schema::create('usuario_categoria_habilitacaos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('categoria_habilitacaos_id')->constrained('categoria_habilitacaos');
            $table->bigInteger('credito')->default(20);


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
        Schema::dropIfExists('usuario_categoria_habilitacaos');
    }
};
