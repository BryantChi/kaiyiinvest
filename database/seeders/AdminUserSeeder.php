<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 建立工程師帳號（最高權限；id=1 Bryant 預設為 engineer 角色）
        // firstOrCreate：帳號已存在則保留既有密碼/資料，不覆寫；assignRole 對既有角色冪等
        $engineer = User::firstOrCreate(
            ['email' => 'bryantchi.work@gmail.com'],
            [
                'name' => 'Bryant',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $engineer->assignRole(User::ENGINEER_ROLE);
        // 建立超級管理員
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super-admin');

        $this->command->info('超級管理員已建立');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
        $this->command->warn('請立即修改預設密碼!');

        // 建立測試用戶 (可選)
        if (app()->environment('local')) {
            // 管理員
            $admin = User::firstOrCreate(
                ['email' => 'admin-user@example.com'],
                ['name' => 'Admin User', 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $admin->assignRole('admin');

            // 編輯
            $editor = User::firstOrCreate(
                ['email' => 'editor@example.com'],
                ['name' => 'Editor User', 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $editor->assignRole('editor');

            // 作者
            $author = User::firstOrCreate(
                ['email' => 'author@example.com'],
                ['name' => 'Author User', 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $author->assignRole('author');

            $this->command->info('測試用戶已建立 (僅限本地環境)');
            $this->command->info('- admin-user@example.com (Admin)');
            $this->command->info('- editor@example.com (Editor)');
            $this->command->info('- author@example.com (Author)');
            $this->command->info('所有密碼: password');
        }
    }
}
