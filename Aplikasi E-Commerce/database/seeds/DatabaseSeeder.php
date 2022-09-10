<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CouriersTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(BerandasTableSeeder::class);
        $this->call(RekeningsTableSeeder::class);
        $this->call(ProduksTableSeeder::class);
        $this->call(DiskonsTableSeeder::class);
    }
}
