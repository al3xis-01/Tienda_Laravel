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
        $this->down();
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255);
            $table->text('descripcion');
            $table->decimal('precio_venta');
            $table->integer('minimo');
            $table->integer('maximo');
            $table->string('imagen');
            $table->date('fecha_caducidad')->nullable()->default(null);
            $table->bigInteger('id_categoria')->index()->unsigned();
            $table->foreign('id_categoria')->references('id')->on('categoria')->cascadeOnDelete();
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
        Schema::dropIfExists('producto');
    }
};
