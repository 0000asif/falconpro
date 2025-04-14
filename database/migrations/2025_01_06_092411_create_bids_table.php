<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('type_id');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 15, 2);
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders')->cascadeOnUpdate();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
