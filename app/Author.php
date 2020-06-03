<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Author extends Model
{

  var $fillable = ['name', 'slug'];

    public function products(){
      return $this->hasMany(Product::class);
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
