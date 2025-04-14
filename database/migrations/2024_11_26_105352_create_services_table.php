<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->decimal('charge', 10, 2);
            $table->dateTime('start_date');
            $table->integer('complete_date');
            $table->text('description');
            $table->text('note');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('services');
    }
}
