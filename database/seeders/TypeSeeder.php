<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\type;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Frontend',
            'Backend',
            'Fullstack',
            'Design'
        ];

        foreach($types as $e){
            $new_type = new Type();
            $new_type->name = $e;
            $new_type->slug = Str::slug($new_type->name);
            $new_type->save();
        }
        

    }
}
