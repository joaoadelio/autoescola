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
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aluno_id')->constrained('users');
            $table->foreignId('categoria_habilitacaos_id')->constrained('categoria_habilitacaos');
            $table->foreignId('veiculo_id')->constrained('veiculos');

            $table->date('data_agendamento');
            $table->time('hora_agendamento');
            $table->enum('status', ['Em andamento', 'Concluída', 'Falta', 'Agendado']);
            $table->smallInteger('valor_credito')->default(1);

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
        Schema::dropIfExists('aulas');
    }
};
