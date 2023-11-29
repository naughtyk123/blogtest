<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert(
            array(
                'category_name'     =>   'Nature',
            )
        );

        DB::table('categories')->insert(
            array(
                'category_name'     =>   'Gaming',
            )
        );

        DB::table('categories')->insert(
            array(
                'category_name'     =>   'Politics',
            )
        );
    }
}
