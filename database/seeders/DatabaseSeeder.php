<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@hoclieu.vn'],
            [
                'name' => 'Admin HocLieu',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'is_banned' => false,
            ]
        );

        // Reset categories and rebuild for elementary school structure
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─── Cấp 1: Khối học ────────────────────────────────────────────
        $tth = Category::create([
            'name'       => 'Tiền tiểu học',
            'icon'       => 'fa-child',
            'sort_order' => 1,
            'type'       => 'grade',
        ]);

        $grades      = [];
        $gradeIcons  = ['fa-1', 'fa-2', 'fa-3', 'fa-4', 'fa-5'];
        foreach (range(1, 5) as $n) {
            $grades[$n] = Category::create([
                'name'       => "Lớp $n",
                'icon'       => $gradeIcons[$n - 1],
                'sort_order' => $n + 1,
                'type'       => 'grade',
            ]);
        }

        // ─── Cấp 2: Tiền tiểu học ───────────────────────────────────────
        // subject = null (không phân môn), doc_type = loại hoạt động
        foreach ([
            ['name' => 'Tô màu',      'icon' => 'fa-paintbrush', 'sort_order' => 1, 'subject' => null, 'doc_type' => 'Tô màu'],
            ['name' => 'Toán tư duy', 'icon' => 'fa-brain',      'sort_order' => 2, 'subject' => null, 'doc_type' => 'Toán tư duy'],
            ['name' => 'Luyện viết',  'icon' => 'fa-pencil',     'sort_order' => 3, 'subject' => null, 'doc_type' => 'Luyện viết'],
            ['name' => 'Luyện đọc',   'icon' => 'fa-book-open',  'sort_order' => 4, 'subject' => null, 'doc_type' => 'Luyện đọc'],
        ] as $sub) {
            Category::create(array_merge($sub, ['parent_id' => $tth->id, 'type' => 'subject']));
        }

        // ─── Cấp 2: Lớp 1–5 ─────────────────────────────────────────────
        // subject = môn học, doc_type = dạng bài
        $gradeSubs = [
            ['name' => 'Toán - Đề kiểm tra',             'icon' => 'fa-calculator',    'sort_order' => 1, 'subject' => 'Toán',       'doc_type' => 'Đề kiểm tra'],
            ['name' => 'Toán - Đề ôn tập',               'icon' => 'fa-rotate',        'sort_order' => 2, 'subject' => 'Toán',       'doc_type' => 'Đề ôn tập'],
            ['name' => 'Toán - Rèn luyện kĩ năng',       'icon' => 'fa-dumbbell',      'sort_order' => 3, 'subject' => 'Toán',       'doc_type' => 'Rèn luyện kĩ năng'],
            ['name' => 'Tiếng Việt - Đề kiểm tra',       'icon' => 'fa-pen-nib',       'sort_order' => 4, 'subject' => 'Tiếng Việt', 'doc_type' => 'Đề kiểm tra'],
            ['name' => 'Tiếng Việt - Đề ôn tập',         'icon' => 'fa-book-bookmark', 'sort_order' => 5, 'subject' => 'Tiếng Việt', 'doc_type' => 'Đề ôn tập'],
            ['name' => 'Tiếng Việt - Rèn luyện kĩ năng', 'icon' => 'fa-feather',       'sort_order' => 6, 'subject' => 'Tiếng Việt', 'doc_type' => 'Rèn luyện kĩ năng'],
        ];
        foreach (range(1, 5) as $n) {
            foreach ($gradeSubs as $sub) {
                Category::create(array_merge($sub, ['parent_id' => $grades[$n]->id, 'type' => 'subject']));
            }
        }
    }
}
