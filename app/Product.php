<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

  var $fillable = ['title', 'category_id', 'author_id', 'images'];

  public function category(){
    return $this->belongsTo(Category::class);
  }
}
