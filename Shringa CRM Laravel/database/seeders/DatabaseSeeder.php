<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Call seeders in correct order
        $this->call([
            UsersTableSeeder::class,
            LeadsTableSeeder::class,
            ClientsTableSeeder::class,
        ]);
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }
}
