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
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_connect_id')->nullable()->after('email');
            $table->boolean('stripe_connect_enabled')->default(false)->after('stripe_connect_id');
            $table->timestamp('stripe_connect_created_at')->nullable()->after('stripe_connect_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['stripe_connect_id', 'stripe_connect_enabled', 'stripe_connect_created_at']);
        });
    }
};
