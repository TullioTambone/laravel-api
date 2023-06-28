<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Project;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker )
    {
        for ($i=0; $i < 10; $i++) { 
            $new_project = new Project();
            $new_project->title = $faker->randomElement(['proj 1', 'proj 2', 'proj 3', 'proj 4', 'proj 5']);
            $new_project->description = $faker->randomElement(['description 1', 'description 2', 'description 3', 'description 4', 'description 5']);
            $new_project->slug = Str::slug($new_project->title, '-');
            $new_project->img = $faker->imageUrl(640, 480, 'animals', true);
            $new_project->save();
        }
    }
}
