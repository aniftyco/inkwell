<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->string('subject')->nullable();
            $table->longText('body');
            $table->string('message_id')->nullable();
            $table->string('in_reply_to')->nullable();
            $table->text('references')->nullable();
            $table->json('headers')->nullable();
            $table->timestamps();

            $table->index('message_id');
            $table->index('in_reply_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_replies');
    }
};
