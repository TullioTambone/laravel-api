<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Admin\Technology;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = [
            'HTML',
            'CSS',
            'bootstrap',
            'JavaScript',
            'Vue',
            'PHP',
            'laravel',
        ];

        foreach($technologies as $e){
            $new_technology = new Technology();
            $new_technology->name = $e;
            $new_technology->slug = Str::slug($new_technology->name);
            $new_technology->save();
        }
    }
}
