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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['image', 'video', '3d_model']);
            $table->string('category')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('preview_path')->nullable();
            $table->string('format')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
            $table->string('storage_disk')->default('public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
