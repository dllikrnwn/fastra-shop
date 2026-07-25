<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->decimal('rate', 10, 2)->nullable()->after('description');
            $table->boolean('has_custom_amount')->default(false)->after('rate');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['rate', 'has_custom_amount']);
        });
    }
};
