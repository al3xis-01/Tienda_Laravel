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
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->string('folio',255);
            $table->bigInteger('id_cliente')->index()->unsigned();
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->enum('estado_venta',['COBRADA','PENDIENTE','CANCELADA']);
            $table->dateTime('fecha')->useCurrent();
            $table->decimal('subtotal');
            $table->decimal('total');
            $table->string('total_letras')->nullable();
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
        Schema::dropIfExists('venta');
    }
};
