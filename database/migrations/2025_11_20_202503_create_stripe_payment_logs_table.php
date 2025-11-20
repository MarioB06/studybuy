<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stripe_payment_logs', function (Blueprint $table) {
            $table->id();

            // optional relations
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Stripe data
            $table->string('type')->default('payment_intent'); // e.g. payment_intent, refund
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_charge_id')->nullable();

            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('status')->nullable(); // succeeded, pending, failed, canceled, etc.
            $table->string('payment_method_type')->nullable(); // card, ideal, etc.

            $table->json('payload')->nullable(); // raw stripe response/webhook
            $table->string('error_message')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stripe_payment_logs');
    }
};
