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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger( 'first_user_id');
            $table->index('first_user_id', 'first_user_idx');
            $table->foreign('first_user_id', 'first_user_fk')->on('users')->references('id');

            $table->unsignedBigInteger( 'second_user_id');
            $table->index('second_user_id', 'second_user_idx');
            $table->foreign('second_user_id', 'second_user_fk')->on('users')->references('id');

            $table->string( 'status', 64);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
