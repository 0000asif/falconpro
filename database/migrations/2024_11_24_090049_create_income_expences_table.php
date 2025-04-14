<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeExpencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_expences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('income_expence_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->dateTime('date');
            $table->string('reference')->nullable();
            $table->decimal('income_amount', 40, 2)->nullable();
            $table->decimal('expence_amount', 40, 2)->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('type');
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
        Schema::dropIfExists('income_expences');
    }
}
