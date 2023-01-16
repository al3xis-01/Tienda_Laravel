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
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_venta')->index()->unsigned();
            $table->foreign('id_venta')->references('id')->on('venta');
            $table->bigInteger('id_inventario')->index()->unsigned();
            $table->foreign('id_inventario')->references('id')->on('inventario');
            $table->integer('cantidad')->unsigned();
            $table->decimal('descuento');
            $table->decimal('precio_venta')->unsigned();
            $table->decimal('total')->unsigned();
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
        Schema::dropIfExists('detalle_venta');
    }
};
