<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_forum_messages', function (Blueprint $table) {
            $table->id();

            // Produkt
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            // Wer hat es geschrieben
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Antwort auf Nachricht → null = Hauptfrage
            $table->foreignId('parent_id')
                ->nullable()
                ->references('id')
                ->on('product_forum_messages')
                ->cascadeOnDelete();

            // Inhalt
            $table->text('message');

            // optional: ob der Beitrag eine offizielle Antwort des Verkäufers ist
            $table->boolean('is_official')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_forum_messages');
    }
};
