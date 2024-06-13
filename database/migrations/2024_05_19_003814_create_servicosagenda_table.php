<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicosagendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicosagenda', function (Blueprint $table) {
            $table->unsignedBigInteger('idservico');
            $table->unsignedBigInteger('idagenda');

            $table->foreign('idservico')
                  ->references('idservico')
                  ->on('servicos')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

            $table->foreign('idagenda')
                  ->references('idagenda')
                  ->on('agenda')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');

            $table->primary(['idservico', 'idagenda']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicosagenda');
    }
}
