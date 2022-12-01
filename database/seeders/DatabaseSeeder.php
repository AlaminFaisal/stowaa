<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(20)->create();


        $this->call([
            //CategorySeeder::class,
            //ColorSeeder::class,
            //SizeSeeder::class,
            ProductSeeder::class,
        ]);

    }
}
