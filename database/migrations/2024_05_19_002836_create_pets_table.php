<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id('idpet');
            $table->string('nome', 50);
            $table->date('datanasc')->nullable();
            $table->char('sexo', 1)->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('porte', 20)->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->unsignedBigInteger('idusuario');

            $table->foreign('idusuario')
                  ->references('idusuario')
                  ->on('usuarios')
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
        Schema::dropIfExists('pets');
    }
}
