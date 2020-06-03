<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{

  var $fillable = ['title', 'slug', 'parent_id'];

  //Returns child categories
  public function childs(){
    return $this->hasMany(Category::class, 'parent_id');
  }

  //Returns parent category
  public function parent(){
    return $this->belongsTo(Category::class);
  }
  //Returns direct childs
  public function products(){
    return $this->hasMany(Product::class);
  }
  //Return childrens products
  public function childs_products(){
    return $this->hasManyThrough(Product::class, Category::class, 'parent_id');
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
