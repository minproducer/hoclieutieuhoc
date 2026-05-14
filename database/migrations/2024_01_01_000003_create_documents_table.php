<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('drive_file_id')->nullable();
            $table->string('drive_view_link')->nullable();
            $table->enum('file_type', ['pdf', 'docx', 'pptx', 'xlsx', 'zip', 'image'])->default('pdf');
            $table->unsignedInteger('file_size_kb')->nullable();
            $table->unsignedSmallInteger('page_count')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('uploader_id')->nullable();
            $table->enum('status', ['draft', 'published', 'hidden'])->default('draft');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->tinyInteger('grade_level')->unsigned()->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();

            $table->foreign('uploader_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['status', 'is_featured']);
            $table->index(['category_id', 'status']);
            $table->index('grade_level');
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
