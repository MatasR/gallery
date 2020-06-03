<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Author;
use App\Product;

class AppController extends Controller
{
    public function home(){

      $initCategory = Category::whereNull('parent_id')->inRandomOrder()->first();
      $initCategory = Category::find(1);

      $products = $initCategory->products()->simplePaginate(15);

      return view('pages.index', compact('initCategory', 'products'));

    }

    public function category(Category $cat){

      $initCategory = $cat;

      // Check if there is child cat with the same slug
      // and select it if present
      if($cat->childs->where('slug', $cat->slug)->first())
        $initCategory = $cat->childs->where('slug', $cat->slug)->first();

      $products = $initCategory->products()->simplePaginate(15);

      return view('pages.index', compact('initCategory', 'products'));

    }

    public function product(Category $cat, Product $product){

      return view('pages.product', compact('cat', 'product'));

    }

    public function authors(){

      return view('pages.authors');

    }

    public function author(Author $author){

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
