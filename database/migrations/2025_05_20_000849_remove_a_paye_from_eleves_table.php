<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->dropColumn('a_paye');
        });
    }

    public function down(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->boolean('a_paye')->default(false); // لإرجاعه إذا رجعت migration
        });
    }
};
