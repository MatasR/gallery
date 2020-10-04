<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Author;
use TCG\Voyager\Facades\Voyager;

class AjaxController extends Controller
{

    // Main search suggestions
    public function mainSearch(Request $request){

      if(!$request->searchInput || !$request->searchType)
        return false;

      // 1. Search in authors
      if($request->searchType == 'authors'){
        $result =  Author::with('products')->has('products')->where('fullname', 'LIKE', '%'.$request->searchInput.'%')->pluck('fullname', 'slug');
        $url = '/autorius/';
      }

      // 2. Search in categories
      if($request->searchType == 'categories'){
        $result = Category::with('products')->has('products')->where('title', 'LIKE', '%'.$request->searchInput.'%')->pluck('title', 'slug');
        $url = '/';
      }

      // 3. Search in products
      if($request->searchType == 'products')
        $result = Product::where('title', 'LIKE', '%'.$request->searchInput.'%')->pluck('title', 'slug');


      foreach($result as $slug => $fullname){
          $res[] = [
            'text' => $fullname,
            'url' => $url.$slug
          ];
      }
      return $res;

    }

    // Infinite scroll pagination
    public function loadMore(Request $request)
    {

      $category = Category::where('slug', $request->cat)->first();
      $page = $request->page;
      $perPage = 10;

      return view('includes.cards')->with([
        'category' => $category,
        'page' => $page,
        'perPage' => $perPage
      ]);

    }

    // Show card modal with more info about product
    public function modal(Request $request)
    {
      $product = Product::find($request->id);

      return response()->json([
        'id' => $product->id,
        'title' => $product->title,
        'short_desc' => $product->short_desc,
        'author' => ($product->author?[
          'name' => $product->author->name,
          'id' => $product->author->id
        ]:false),
        'image' => Voyager::image(json_decode($product->image)[0]),
        'description' => '',
        'category' => $product->category->title,
      ]);
    }
}
