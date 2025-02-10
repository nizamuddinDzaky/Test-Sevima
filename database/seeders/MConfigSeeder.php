<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_config')->insert([
            [
                'key' => 'photo_profile',
                'title' => 'Photo Profile',
                'type' => 'image',
            ],
            [
                'key' => 'bio',
                'title' => 'Profile Bio',
                'type' => 'textarea',
            ],
            [
                'key' => 'enable_comment',
                'title' => 'Enable Comment',
                'type' => 'checkbox',
            ],
        ]);
    }
}
