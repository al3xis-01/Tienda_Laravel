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
        Schema::create('alta_producto', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->dateTime('fecha');
            $table->enum('motivo',['COMPRA_PROVEEDOR','REGALO']);
            $table->bigInteger('id_proveedor')->index()->unsigned();
            $table->foreign('id_proveedor')->references('id')->on('proveedor');
            $table->decimal('descuento')->default(0);
            $table->decimal('subtotal');
            $table->decimal('total');
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
        Schema::dropIfExists('alta_producto');
    }
};
