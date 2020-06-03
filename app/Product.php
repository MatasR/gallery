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

  public function author(){
    return $this->belongsTo(Author::class);
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
