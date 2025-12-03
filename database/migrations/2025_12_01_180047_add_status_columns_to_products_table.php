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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('erhalten')->default(false)->after('sold_at');
            $table->boolean('uebergeben')->default(false)->after('erhalten');
            $table->boolean('abgeschlossen')->default(false)->after('uebergeben');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['erhalten', 'uebergeben', 'abgeschlossen']);
        });
    }
};
