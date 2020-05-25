<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use TCG\Voyager\Facades\Voyager;

class AjaxController extends Controller
{
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
