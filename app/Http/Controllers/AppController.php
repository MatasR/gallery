<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Author;
use App\Product;

class AppController extends Controller
{
    public function home(){

      // Random initCategory for testing purposes
      $initCategory = Category::doesntHave('childs')->inRandomOrder()->first();

      $products = $initCategory->products()->simplePaginate(15);

      return view('pages.index', compact('initCategory', 'products'));

    }

    public function category(Category $cat){

      // Check if there is child cat with the same slug
      // and select it if present
      if($cat->childs->where('slug', $cat->slug)->first())
        $cat = $cat->childs->where('slug', $cat->slug)->first();

      $products = $cat->products()->simplePaginate(15);

      $pageTitle = $cat->title;

      return view('pages.index', compact('cat', 'products', 'pageTitle'));

    }

    public function product(Category $cat, Product $product){

      $pageTitle = $product->title;

      $product->views++;
      $product->save();

      return view('pages.product', compact('cat', 'product', 'pageTitle'));

    }

    public function authors(){

      $pageTitle = 'Autoriai';

      return view('pages.authors', compact('pageTitle'));

    }

    public function author(Author $author){

      $initCategory = $author->categories->unique()->first();

      $pageTitle = $author->name;

      return view('pages.author', compact('author', 'initCategory', 'pageTitle'));

    }

    public function about(){

      $pageTitle = 'Apie mus';

      return view('pages.about', compact('pageTitle'));

    }
}
