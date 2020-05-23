<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class Product extends Model
{

  use Resizable;

  var $fillable = ['title', 'short_desc', 'category_id', 'author_id', 'image'];

  public function category(){
    return $this->belongsTo(Category::class);
  }
}
