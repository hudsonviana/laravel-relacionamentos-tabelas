<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'available'];

    public function modules() {
        return $this->hasMany(Module::class);
    }

    // relacionamento one-to-one polimórfico
    public function image() {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
