<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Parcel;
use Database\Factories\ParcelFactory;
use Illuminate\Database\Seeder;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // $this->call([
        //     UserSeeder::class,
        //     ParcelSeeder::class
        // ]);

         \App\Models\User::factory()->count(5)
         ->has(Parcel::factory()->count(4), 'parcelsOfSenders')
         ->create([
             'type' => 'sender',
         ]);

         \App\Models\User::factory()->count(10)->create([
            'type' => 'biker',
        ]);
        // \App\Models\User::factory(9)->create([
        //     'type' => 'biker',
        //     'password' => bcrypt('gaditek'),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Haris Haider',
        //     'email' => 'eharishaider@gmail.com',
        //     'type' => 'sender',
        //     'password' => bcrypt('gaditek'),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Haris Haider Bike',
        //     'email' => 'harishaider94@gmail.com',
        //     'type' => 'biker',
        //     'password' => bcrypt('gaditek'),
        // ]);
    }
}
