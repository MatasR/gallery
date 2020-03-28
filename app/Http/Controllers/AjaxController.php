<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class AjaxController extends Controller
{
    // Show card modal with more info about product
    public function product(Request $request)
    {
      $product = Product::find($request->id);

      return response()->json([
        'title' => $product->title,
        'image' => $product->image->src,
        'description' => '',
        'category' => $product->category->title,
      ]);
    }
}
