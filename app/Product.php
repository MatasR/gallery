<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;
use Illuminate\Support\Str;

class Product extends Model
{

  use Resizable;

  var $fillable = ['title', 'short_desc', 'category_id', 'author_id', 'image'];

  protected static function booted()
  {
    static::created(function ($product) {
      $product->slug = Str::of($product->id . ' ' . $product->title)->slug('-');

      $product->save();
    });

    static::updating(function ($product) {
      $product->slug = Str::of($product->id . ' ' . $product->title)->slug('-');
    });
  }

  public function category(){
    return $this->belongsTo(Category::class);
  }

  public function author(){
    return $this->belongsTo(Author::class);
  }

  public function getTitleNumberAttribute(){
    preg_match('/[0-9]+/', $this->title, $numbers);
    if($numbers)
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
