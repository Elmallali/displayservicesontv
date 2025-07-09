<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            // Add the niveau column if it doesn't exist
            if (!Schema::hasColumn('formations', 'niveau')) {
                $table->string('niveau')->after('description')->default('Débutant');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            if (Schema::hasColumn('formations', 'niveau')) {
                $table->dropColumn('niveau');
            }
        });
    }
};
