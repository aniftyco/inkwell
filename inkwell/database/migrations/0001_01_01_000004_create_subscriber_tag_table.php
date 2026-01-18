<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriber_tag', function (Blueprint $table) {
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['subscriber_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriber_tag');
    }
};
