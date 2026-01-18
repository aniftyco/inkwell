<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('reply_type');
            $table->unsignedBigInteger('reply_id');
            $table->timestamps();

            $table->index(['reply_type', 'reply_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
