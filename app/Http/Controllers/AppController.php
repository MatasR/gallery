<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Author;
use App\Product;
use App\BrokenLink;
use App\AboutUs;

class AppController extends Controller
{
    public function home(){

      // Random initCategory for testing purposes
      $initCategory = Category::doesntHave('childs')->inRandomOrder()->first();

      $products = $initCategory->products()->simplePaginate(15)->withPath($initCategory->slug);

      // Distinct leaves only unique authors
      $authors = $initCategory->authors()->orderBy('surname')->distinct()->simplePaginate(15);

      return view('pages.index', compact('initCategory', 'products', 'authors'));

    }

    // Temp new category function for broken links to work
    public function category($category){

      $cat = Category::where('slug', $category)->first();
      if($cat){

        // Check if there is child cat with the same slug
        // and select it if present
        if($cat->childs->where('slug', $cat->slug)->first())
          $cat = $cat->childs->where('slug', $cat->slug)->first();

        // Order products by its title number
        $products = $cat->products()->orderByRaw('LENGTH(title)','ASC')->orderBy('title', 'ASC')->simplePaginate(15);

        // Distinct leaves only unique authors
        $authors = $cat->authors()->orderBy('surname')->distinct()->simplePaginate(15);

        $pageTitle = $cat->title;

        return view('pages.index', compact('cat', 'products', 'authors','pageTitle'));

      }else{
        // Temp broken links function

        $this->brokenLinks();

      }

    }

    /*public function category(Category $cat){

      // Check if there is child cat with the same slug
      // and select it if present
      if($cat->childs->where('slug', $cat->slug)->first())
        $cat = $cat->childs->where('slug', $cat->slug)->first();

      $products = $cat->products()->simplePaginate(15);

      $pageTitle = $cat->title;

      return view('pages.index', compact('cat', 'products', 'pageTitle'));

    }*/

    // Temp new product function for broken links to work
    public function product($category, $product){

      $product = Product::where('slug', $product)->first();
      if($product){

        $cat = $product->category;

        $pageTitle = $product->title;

        $product->views++;
        $product->save();

        return view('pages.product', compact('cat', 'product', 'pageTitle'));
      }else{
        // Temp broken links function

        $this->brokenLinks();

      }

    }

    /*public function product(Category $cat, Product $product){

      $pageTitle = $product->title;

      $product->views++;
      $product->save();

      return view('pages.product', compact('cat', 'product', 'pageTitle'));

    }*/

    public function authors(){

      $pageTitle = 'Autoriai';

      // We need to order by surname while we only have a full name
      $authors = Author::with('products')->get();

      return view('pages.authors', compact('pageTitle', 'authors'));

    }

    public function author(Author $author){

      $initCategory = $author->categories->unique()->first();

      $pageTitle = $author->name;

      return view('pages.author', compact('author', 'initCategory', 'pageTitle'));

    }

    public function about(){

      $pageTitle = 'Apie mus';

      $AboutUs = AboutUs::first();

      return view('pages.about', compact('pageTitle', 'AboutUs'));

    }

    // Function for fixing broken links with 3 segments
    public function url($url1, $url2, $url3){

      $this->brokenLinks();

    }

    // Temp funciton to fix broken links and redirect to new ones
    private function brokenLinks(){

      $url = $_SERVER['REQUEST_URI'];

      // 1. Check if already exists
        // 1.2. Check if it has a new link
          // 1.2.2. Redirect to new link and increase redirect count
        // 1.3. Increase view to this link
      // 2. Create broken links item with old link and 1 view
      // 3. Redirect to 404

      $brokenLink = BrokenLink::where('old_link', $url)->first();
      if($brokenLink){

        $brokenLink->visits++;
        $brokenLink->save();

        if($brokenLink->new_link){

          $brokenLink->redirects++;
          $brokenLink->save();

          return redirect($brokenLink->new_link, 301)->send();

        }else
          abort(404);

      }else{

        $brokenLink = new BrokenLink;
        $brokenLink->old_link = $url;
        $brokenLink->visits++;
        $brokenLink->save();

        abort(404);

      }

    }
}
