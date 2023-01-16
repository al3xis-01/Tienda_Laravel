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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_producto')->index()->unsigned();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->bigInteger('id_alta')->index()->unsigned();
            $table->foreign('id_alta')->references('id')->on('alta_producto');
            $table->integer('existencia')->unsigned();
            $table->integer('precio_venta')->unsigned();
            $table->integer('precio_compra')->unsigned();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('inventario');
    }
};
