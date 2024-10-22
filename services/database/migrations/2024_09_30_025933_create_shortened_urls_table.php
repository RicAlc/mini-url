<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('shortened_urls', function (Blueprint $table) {
            $table->id();
            $table->text('original_url');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('shortened_url', length: 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('shortened_urls');
    }
};