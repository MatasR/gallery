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
        'image' => asset('storage'.$product->images),
        'description' => '',
        'category' => $product->category->title,
      ]);
    }
}
