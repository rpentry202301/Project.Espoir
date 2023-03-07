<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'id'         => '1',
                    'name'       => 'admin',
                    'email'      => 'admin@admin',
                    'password'   => Hash::make('adminadmin'),
                    'admin_flag' => '1'
                ],
                [
                    'id'         => '2',
                    'name'       => 'テスト太郎',
                    'email'      => 'test@test',
                    'password'   => Hash::make('testtest'),
                    'admin_flag' => '0'
                ]
            ]
        );
        // factory(User::class)->create([
        //     'id'         => '1',
        //     'name'       => 'admin',
        //     'email'      => 'admin@admin',
        //     'password'   => Hash::make('adminadmin'),
        //     'admin_flag' => 'true'
        // ]);

        // factory(User::class)->create([
        //     'id'         => '2',
        //     'name'       => '山田太郎',
        //     'email'      => 'yamada@gmail.com',
        //     'password'   => Hash::make('yamadataro'),
        //     'admin_flag' => 'false'
        // ]);
    }
}
