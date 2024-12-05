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
        Schema::table('collaborators', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('phone');
        });
    }
    
    public function down()
    {
        Schema::table('collaborators', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
    
};
