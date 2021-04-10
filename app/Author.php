<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Author extends Model
{
    public function products(){
      return $this->hasMany(Product::class)->orderBy('title');
    }

    public function categories(){
      return $this->belongsToMany(Category::class, Product::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
