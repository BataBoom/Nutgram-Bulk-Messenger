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
        Schema::create('telegram_spam', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('chat_id');
            $table->foreignId('msg_id')->constrained('telegram_spam_msgs')->onDelete('cascade');
            $table->boolean('sent')->default(false);
            $table->timestamps();

            $table->unique(['msg_id', 'chat_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('telegram_spam', function (Blueprint $table) {
            $table->dropForeign(['msg_id']);
            $table->dropUnique('telegram_spam_msg_id_chat_id_unique');
        });

        Schema::dropIfExists('telegram_spam');
    }
};