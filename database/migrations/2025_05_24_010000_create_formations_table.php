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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('niveau_langue'); // A1, A2, B1, B2, C1, C2
            $table->string('langue'); // français, anglais, espagnol, etc.
            $table->decimal('prix_mensuel', 8, 2);
            $table->integer('duree_mois')->default(1);
            $table->integer('places_maximum')->default(15);
            $table->integer('places_disponibles')->default(15);
            $table->foreignId('formateur_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
