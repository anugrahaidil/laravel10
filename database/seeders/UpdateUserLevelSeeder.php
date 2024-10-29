<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Perbarui pengguna yang belum memiliki level menjadi 'user'
        DB::table('users')
            ->whereNull('level')
            ->update(['level' => 'user']);
    }
}
