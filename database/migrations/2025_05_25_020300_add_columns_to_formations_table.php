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
            // Add the missing columns if they don't exist
            if (!Schema::hasColumn('formations', 'niveau_langue')) {
                $table->string('niveau_langue')->after('description');
            }
            
            if (!Schema::hasColumn('formations', 'langue')) {
                $table->string('langue')->after('niveau_langue');
            }
            
            if (!Schema::hasColumn('formations', 'places_maximum')) {
                $table->integer('places_maximum')->after('duree_mois')->default(20);
            }
            
            if (!Schema::hasColumn('formations', 'places_disponibles')) {
                $table->integer('places_disponibles')->after('places_maximum')->default(20);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn(['niveau_langue', 'langue', 'places_maximum', 'places_disponibles']);
        });
    }
};
