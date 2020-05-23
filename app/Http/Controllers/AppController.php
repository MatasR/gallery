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

      $products = $initCategory->products()->simplePaginate(15);

      return view('pages.index', compact('initCategory', 'products'));

    }

    public function category(Request $request){

      if($request->subcat)
        $cat = $request->subcat;
      else
        $cat = $request->cat;

      $initCategory = Category::where('slug', $cat)->orderBy('parent_id', 'desc')->first();

      $products = $initCategory->products()->simplePaginate(15);

      return view('pages.index', compact('initCategory', 'products'));

    }

    public function authors(){

      return view('pages.authors');

    }

    public function author(Request $request){

      $author = Author::find($request->id);
      $initCategory = $author->categories->unique()->first();

      return view('pages.author')->with([
        'author' => $author,
        'initCategory' => $initCategory
      ]);

    }

    public function about(){

      return view('pages.about');

    }
}
