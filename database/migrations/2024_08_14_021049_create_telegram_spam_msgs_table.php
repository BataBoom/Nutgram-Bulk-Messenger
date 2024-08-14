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
        Schema::create('telegram_spam_msgs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('sha1_msg_hash')->unique();
            $table->longText('message');
            $table->json('recipients')->comment('array of chat_ids');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('telegram_spam_msgs', function (Blueprint $table) {
            $table->dropUnique('telegram_spam_msgs_title_unique');
            $table->dropUnique('telegram_spam_msgs_sha1_msg_hash_unique');
        });
        
        Schema::dropIfExists('telegram_spam_msgs');
    }
};
