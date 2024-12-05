<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborator_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaborator_id')->constrained()->onDelete('cascade');
            $table->string('task_name');
            $table->date('date_created');
            $table->date('deadline')->nullable();
            $table->boolean('important')->default(false);
            $table->json('documents')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Price field for tasks
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
        Schema::dropIfExists('collaborator_tasks');
    }
}
