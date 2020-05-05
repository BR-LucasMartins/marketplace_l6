<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tabela de pedidos

        Schema::create('user_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');  //referencia do usuario
            $table->unsignedBigInteger('store_id'); //referencia da loja 

            $table->string('reference');
            $table->string('pagseguro_code');
            $table->integer('pagseguro_status');

            $table->text('items');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');  //referencia com chave no tabela user
            $table->foreign('store_id')->references('id')->on('stores');  //referencia com chave no tabela user
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders');
    }
}
