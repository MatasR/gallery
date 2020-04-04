<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Author extends Model
{
    public function products(){
      return $this->hasMany(Product::class);
    }

    public function categories(){
      return $this->belongsToMany(Category::class, Product::class);
    }
}
