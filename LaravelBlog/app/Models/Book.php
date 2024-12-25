<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    protected $fillable = ['title', 'author', 'description', 'published_year','img'];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

}
