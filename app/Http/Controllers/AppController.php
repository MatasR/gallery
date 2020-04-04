<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Author;

class AppController extends Controller
{
    public function home(){

      $initCategory = Category::whereNull('parent_id')->inRandomOrder()->first();
      $initCategory = Category::find(1);

      return view('pages.home')->with('initCategory', $initCategory);

    }

    public function authors(){

      return view('pages.authors');

    }

    public function author(Request $request){

      $author = Author::find($request->id);

      return view('pages.author')->with('author', $author);

    }

    public function about(){

      return view('pages.about');

    }
}
