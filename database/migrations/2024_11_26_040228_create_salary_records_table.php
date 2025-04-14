<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->integer('payment_month'); // Numeric representation of the month (1-12)
            $table->integer('payment_year'); // Year of the payment
            $table->decimal('salary_amount', 10, 2); // Salary amount
            $table->tinyInteger('status');
            $table->dateTime('payment_date')->nullable(); // Date of payment
            $table->text('note')->nullable(); // Optional remarks
            $table->decimal('bonous', 10, 2)->nullable();
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
        Schema::dropIfExists('salary_records');
    }
}
