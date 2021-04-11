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

  public function getTitleNumberAttribute(){
    preg_match('/[0-9]+/', $this->title, $numbers);
    return $numbers[0];
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
