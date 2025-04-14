<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_number')->unique();
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->string('zip_code');
            $table->text('address');
            $table->tinyInteger('status')->default(1); // 1 for active, 0 for inactive
            $table->date('due_date');
            $table->decimal('total_qty', 10, 2)->nullable();
            $table->decimal('grand_total', 40, 2)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        Schema::create('work_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('type_id');
            $table->string('description');
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 15, 2);
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_orders');
    }
}
