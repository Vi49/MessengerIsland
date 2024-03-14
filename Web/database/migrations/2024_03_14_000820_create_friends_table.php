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
        Schema::create('friends', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('first_friend_id')->nullable();
            $table->index('first_friend_id', 'first_friend_id_idx');
            $table->foreign('first_friend_id', 'first_friend_fk')->on('users')->references('id');

            $table->unsignedBigInteger('second_friend_id')->nullable();
            $table->index('second_friend_id', 'second_friend_idx');
            $table->foreign('second_friend_id', 'second_friend_fk')->on('users')->references('id');

            $table->string('status', 30)->default('request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
