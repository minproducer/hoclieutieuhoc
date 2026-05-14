<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // e.g. 'Toán', 'Tiếng Việt', null for pre-K activities
            $table->string('subject', 100)->nullable()->after('icon');
            // e.g. 'Đề kiểm tra', 'Đề ôn tập', 'Rèn luyện kĩ năng', 'Tô màu', 'Toán tư duy', 'Luyện viết', 'Luyện đọc'
            $table->string('doc_type', 100)->nullable()->after('subject');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['subject', 'doc_type']);
        });
    }
};
