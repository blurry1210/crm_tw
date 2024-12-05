<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('collaborator_tasks', function (Blueprint $table) {
        $table->boolean('important')->default(false)->change();
    });
}

public function down()
{
    Schema::table('collaborator_tasks', function (Blueprint $table) {
        $table->boolean('important')->default(false)->change();
    });
}

};