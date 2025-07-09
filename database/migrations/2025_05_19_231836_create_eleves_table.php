<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id(); // ID بسيط
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['homme', 'femme'])->default('homme');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('langue_suivie');
            $table->boolean('a_paye')->default(false); // خلص؟
            $table->timestamps(); // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
