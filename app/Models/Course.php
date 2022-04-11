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

    // relacionamento one-to-many polimórfico
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // relacionamento many-to-many polimórfico
    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
