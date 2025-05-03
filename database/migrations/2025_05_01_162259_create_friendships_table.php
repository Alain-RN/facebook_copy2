<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'utilisateur qui envoie la demande
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade'); // L'utilisateur qui reçoit la demande
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Statut de la relation
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};