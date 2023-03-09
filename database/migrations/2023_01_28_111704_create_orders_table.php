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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketer_id');
            $table->foreign('marketer_id')->references('id')->on('users')->onDelete('Cascade');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign('delivery_id')->references('id')->on('users')->onDelete('set Null');
            $table->string('order_status')->default('0')->comment('0 => pending , 1 => processing , 2 => completed , 3 => refused , 4 => cancelled');
            $table->string('shipping_status')->default('0')->comment('0 => pending , 1 => processing , 2 => completed , 3 => refused');
            $table->text('track_notice_order')->nullable();
            $table->decimal('cash_delivered',12,2)->default(0);
            $table->decimal('cash_delivery_refund',12,2)->nullable();
            $table->text('delivery_notice')->nullable();
            $table->decimal('marketer_profit',12,2)->default(0);
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
        Schema::dropIfExists('orders');
    }
};
