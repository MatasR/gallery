<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
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
}
