<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
  public function image(){
    return $this->hasOne(Image::class);
  }

  public function category(){
    return $this->belongsTo(Category::class);
  }
}
