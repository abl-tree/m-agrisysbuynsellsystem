<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_no');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customer')
                ->onDelete('cascade');
            $table->integer('commodity_id')->unsigned();
            $table->foreign('commodity_id')
                ->references('id')
                ->on('commodity')
                ->onDelete('cascade');
            $table->integer('sacks');
            $table->integer('ca_id')->unsigned();
            $table->foreign('ca_id')
                ->references('customer_id')
                ->on('balance')
                ->onDelete('cascade');
            $table->decimal('balance_id', 14, 2);
            $table->decimal('partial', 14, 2);
            $table->decimal('kilo', 14, 2);
            $table->decimal('tare', 14, 2)->nullable();
            $table->decimal('moist', 14, 2)->nullable();
            $table->decimal('net', 14, 2);
            $table->string('type');
            $table->decimal('price', 14, 2);
            $table->decimal('total', 14, 2);
            $table->decimal('amtpay', 14, 2);
            $table->string('remarks');
            $table->string('status');
            $table->string('released_by');     
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
        Schema::dropIfExists('purchases');
    }
}
