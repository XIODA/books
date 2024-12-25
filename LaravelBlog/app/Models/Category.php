<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use HasFactory;

    protected $fillable = ['name','parent_id'];

    

    //子類別
    public function children(){
        return $this -> hasMany(Category::class, 'parent_id');
    }
    //父類別
    public function parent(){
        return $this -> belongsTo(Category::class,'parent_id');
    }

    public function books(){
        return $this ->belongsToMany(Book::class);
    }
}
