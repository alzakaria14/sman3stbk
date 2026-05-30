<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@sman3stbk.sch.id'],
            [
                'name' => 'Administrator Sekolah',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $this->call([
            SchoolSettingSeeder::class,
            NewsPostSeeder::class,
        ]);
    }
}
