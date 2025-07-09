<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, set a default value for existing records
        DB::table('formations')->whereNull('niveau')->update(['niveau' => 'Débutant']);
        
        // Then modify the column to have a default value
        Schema::table('formations', function (Blueprint $table) {
            $table->string('niveau')->default('Débutant')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->string('niveau')->nullable()->change();
        });
    }
};
