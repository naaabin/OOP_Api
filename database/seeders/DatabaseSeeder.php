<?php

namespace Database\Seeders;

use App\Models\ProjectNote;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
            ProjectTaskSeeder::class,
            TaskUserSeeder::class,  
        ]);
    
      
    }
}
