<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id('idagenda');
            $table->date('data');
            $table->time('hora');
            $table->unsignedBigInteger('idusuario');
            $table->unsignedBigInteger('idpet');

            // Chaves estrangeiras
            $table->foreign('idusuario')
                  ->references('idusuario')
                  ->on('usuarios')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

            $table->foreign('idpet')
                  ->references('idpet')
                  ->on('pets')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

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
        Schema::dropIfExists('agenda');
    }
}
