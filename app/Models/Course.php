<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user (){
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_courses');
    }
}
