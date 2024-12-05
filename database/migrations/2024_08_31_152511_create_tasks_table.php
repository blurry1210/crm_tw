<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('task_number');
            $table->string('task_name');
            $table->dateTime('date_created');
            $table->dateTime('deadline');
            $table->boolean('important')->default(false);
            $table->json('documents')->nullable(); // Store documents as JSON
            $table->timestamps();

            // Unique constraint for task_number per customer
            $table->unique(['customer_id', 'task_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
