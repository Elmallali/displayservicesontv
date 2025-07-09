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
        Schema::table('paiements', function (Blueprint $table) {
            $table->foreignId('formation_id')->nullable()->after('eleve_id')->constrained()->onDelete('set null');
            $table->boolean('est_confirme')->default(false)->after('methode');
            $table->string('commentaire')->nullable()->after('est_confirme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['formation_id']);
            $table->dropColumn('formation_id');
            $table->dropColumn('est_confirme');
            $table->dropColumn('commentaire');
        });
    }
};
