<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();

            $table->string('title');
            $table->text('summary');

            $table->string('original_file_path');
            $table->string('original_file_name');
            $table->string('original_file_mime')->nullable();
            $table->unsignedBigInteger('original_file_size')->nullable();

            $table->string('status')->default('pending_assignment');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};