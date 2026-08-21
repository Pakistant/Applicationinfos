<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kiosk_issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('pdf');
            $table->string('cover')->nullable();
            $table->boolean('isActive')->default(true);
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiosk_issues');
    }
};