<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    
    public static function generateSlug($title) {
        return Str::slug($title, '-');
    }

    protected $table = 'projects';
    protected $fillable = ['title', 'description','slug','img', 'type_id'];

    public function type(){
        return $this->belongsTo( Type::class );

    }
    
    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }
}
