<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AppController extends Controller
{
    public function home(){

      $initCategory = Category::whereNull('parent_id')->inRandomOrder()->first();
      $initCategory = Category::find(1);

      return view('pages.home')->with('initCategory', $initCategory);

    }
}
