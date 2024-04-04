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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('type', 32);
            $table->string('encryption', 64)->nullable();

            $table->unsignedBigInteger( 'first_user_id');
            $table->index('first_user_id', 'first_user_idx');
            $table->foreign('first_user_id', 'first_user_message_fk')->on('users')->references('id');

            $table->unsignedBigInteger( 'second_user_id');
            $table->index('second_user_id', 'second_user_idx');
            $table->foreign('second_user_id', 'second_user_message_fk')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
