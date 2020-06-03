<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Goutte\Client;
use App\Category;
use App\Product;
use App\Author;
use Intervention\Image\ImageManagerStatic as Image;
use TCG\Voyager\Facades\Voyager;

class ScrapController extends Controller
{

    public function makeSlugs(){

      $products = Product::get();
      foreach ($products as $product) {

        //if(!$product->slug){
          $product->slug = $product->id.'-'.Str::slug($product->title, '-');
          $product->save();

          echo $product->id.'.'.$product->title.' -> '.$product->slug.'<br>';
        //}

        //echo $product->id.'.'.$product->title.' = '.$product->slug.'<br>';

      }

    }

    public function convertName(){

      $products = Product::get();
      foreach ($products as $product){

        $image = json_decode($product->image)[0];

        $table = array(
          'Ą'=>'A',
          'ą'=>'a',
          'Č'=>'C',
          'č'=>'c',
          'Ę'=>'E',
          'ę'=>'e',
          'Ė'=>'E',
          'ė'=>'e',
          'Į'=>'I',
          'į'=>'i',
          'Š'=>'S',
          'š'=>'s',
          'Ū'=>'U',
          'ū'=>'u',
          'Ų'=>'U',
          'ų'=>'u',
          'Ž'=>'Z',
          'ž'=>'z'
        );

        $newName = strtr($image, $table);

        echo $image.' -> '.$newName.'<br>';

        rename(storage_path('app/public'.$image), storage_path('app/public'.$newName));

        $product->image = '["'.$newName.'"]';
        $product->save();

      }

    }

    public function makeThumbs(){
      $products = Product::get();
      foreach ($products as $product){

        $currentImage = Voyager::image(json_decode($product->image)[0]);

        echo $product->id.'. '.$currentImage.'<br>';

        $filename = last(explode("/", $currentImage));
        $newName = substr($filename, 0, -4).'-thumb-300.jpg';

        //Check if thumb exists
        if(file_exists(storage_path('app/public/products/May2020/'.$newName)))
          continue;

        $newImage = Image::make($currentImage);
        $newImage->resize(300, null, function ($constraint) {
          $constraint->aspectRatio();
        });
        $newImage->save(storage_path('app/public/products/May2020/'.$newName));

      }
    }

    public function importAuthorProducts(){

      $catID = [
        'grafika' => 11,
        'tapyba' => 12,
        'klasika' => 13
      ];

      foreach($this->getAuthors() as $cat => $authors){

        $cat = $catID[$cat];

        foreach($authors as $i => $author){

          // Skip some authors
          if($i <= 46)
            continue;

          var_dump($i);
          $authorID = Author::where('name', $author['name'])->first()->id;

          $products = $this->getProducts($author['link']);
          foreach($products as $product){

            $this->importProduct($product['title'], $cat, $product['image'], $authorID);

          }

        }

      }

    }

    public function import(){

      //foreach($this->cats() as $cat){

        $cat['title'] = 'Keramika';
        $cat['link'] = 'https://smallgallery.net/keramika/';

        $insertedCat = Category::where('slug', Str::slug($cat['title']))->first();
        if(!$insertedCat){
          // Add cat to categories table
          $insertedCat = Category::create([
            'title' => Str::ucfirst($cat['title']),
            'slug' => Str::slug($cat['title'], '-')
          ]);
        }

        // If has childs
        if(isset($cat['cats'])){
          foreach($cat['cats'] as $subcat){

            $insertedSubcat = Category::where('slug', Str::slug($subcat['title']))->first();
            if(!$insertedSubcat){
              // Add subcat to categories table
              $insertedSubcat = Category::create([
                'title' => Str::ucfirst($subcat['title']),
                'slug' => Str::slug($subcat['title']),
                'parent_id' => $insertedCat->id
              ]);
            }

            // Import products
            $products = $this->getProducts($subcat['link']);
            foreach($products as $product){
              $this->importProduct($product['title'], $insertedSubcat->id, $product['image']);
            }

          }
        }else{

          // No child - import products
          $products = $this->getProducts($cat['link']);
          foreach($products as $product){
            $this->importProduct($product['title'], $insertedCat->id, $product['image']);
          }
        }

      //}

    }

    public function importProducts(){

      $products = $this->getProducts('https://smallgallery.net/antikvaras/');

      //$i = 0;
      foreach($products as $product){

        if($product['title']){

          // Check if product already exists
          if(!Product::where('title', $product['title'])->first()){

            $img = file_get_contents($product['image']);
            $imgName = '/images/April2020/'.substr($product['image'], strrpos($product['image'], '/') + 1);
            Storage::put('/public'.$imgName, $img);

            // Insert to database products table
            $inserted = Product::create([
              'title' => $product['title'],
              'category_id' => 16, //Antikvaras
              //'author_id' => 122, //Levas Žiriakovas
              'images' => '["'.$imgName.'"]'
            ]);

            echo 'Product "'.$product['title'].'" imported with ID:'.$inserted->id.'<br>';

          }else
            echo 'Product "'.$product['title'].'" already exists<br>';

        }else{

          $img = file_get_contents($product['image']);
          $imgName = '/images/April2020/'.substr($product['image'], strrpos($product['image'], '/') + 1);
          Storage::put('/public'.$imgName, $img);

          $images = $inserted->images;
          //$images = str_replace('"', '', $images);
          $images = str_replace('[', '', $images);
          $images = str_replace(']', '', $images);
          $images = explode(',', $images);
          $images[] = '"'.$imgName.'"';
          $images = '['.implode(',', $images).']';

          $inserted->images = $images;
          $inserted->save();

          echo 'Product "'.$inserted->title.'" updated with new image<br>';

        }

        // Limited loop cycle
        //$i++;
        //if($i > 100)
          //break;
      }

    }

    // Import
    private function importProduct($title, $cat, $image, $author){

      // Check if product already exists
      $product = Product::where('title', $title)->first();
      if(!$product){

        // Save image
        $img = file_get_contents($image);
        $imgName = '/images/April2020/'.substr($image, strrpos($image, '/') + 1);
        Storage::put('/public'.$imgName, $img);

        // Insert to database products table
        $inserted = Product::create([
          'title' => $title,
          'category_id' => $cat,
          'author_id' => $author,
          'images' => $imgName
        ]);

        echo 'Product imported with ID:'.$inserted->id.'<br>';
      }else
        echo 'Product already exist: '.$product->id.'<br>';

    }

    // Get a list of products with their data from a sub cat or author cat link
    public function getProducts($url = 'https://smallgallery.net/antikvaras/'){

      $client = new Client();

      $crawler = $client->request('GET', $url);

      // Get a list of products
      $products = $crawler->filter('.envira-gallery-item')->each(function($node){

        if($node->filter('.envira-caption')->count())
          $title = $node->filter('.envira-caption')->text();
        else
          $title = '';

        // Fix titles = remove [0-9]+|
        //$title = preg_replace('/[0-9]+\| /', '', $title);

        $image = $this->largeImage($node->filter('a img')->attr('src'));

        return [
          'title' => $title,
          'image' => $image
        ];

      });

      return $products;

    }

    public function importAuthors(){

      foreach($this->getAuthors() as $cat){
        $x = 0;
        foreach($cat as $author){

          $slug = Str::slug(Str::replaceFirst('Š', 'S', $author['name']), '-');
          //if($x==3)
            //dd($slug);

          $findAuthor = Author::where('slug', $slug)->first();
          if(!$findAuthor){
            Author::create([
              'name' => $author['name'],
              'slug' => $slug
            ]);
            echo $author['name'].' Added to the db<br>';
          }else
            echo $author['name'].' Already exists<br>';

          $x++;
        }
      }

    }

    // Getting authors from nav
    private function getAuthors(){

      $client = new Client();
      $url = 'https://smallgallery.net/';

      $cats = [
        'grafika',
        'tapyba',
        'klasika'
      ];

      // Loop each cat, because each cat has its own authors
      foreach($cats as $cat){
        $crawler = $client->request('GET', $url.$cat);

        // Loop each author
        $author = $crawler->filter('.envira-gallery-item')->each(function($node){

          // Return it's info
          return [
            'name' => $node->filter('.envira-album-title')->text(),
            'link' => $node->filter('a')->attr('href')
          ];

        });

        $authors[$cat] = $author;

      }

      return $authors;

    }

    // Getting cats from nav
    private function cats(){

      $client = new Client();
      $url = 'https://smallgallery.net/';

      $crawler = $client->request('GET', $url);

      // Get a list of cats
      $cats = $crawler->filter('.menu-item-24')->first()->filter('ul > li')->each(function ($node){

        // If has submenu
        if($node->filter('ul')->count()){

          // Loop each sub element
          $subCats = $node->filter('ul li a')->each(function ($subNode){
            return [
              'title' => $subNode->text(),
              'link' => $subNode->attr('href')
            ];
          });

          // Return main cat with childs
          $return = [
            'title' => $node->filter('a')->text(),
            'cats' => $subCats
          ];

        // If main cat without childs
        }else{
          // Just return main cat
          $return = [
            'title' => $node->text(),
            'link' => $node->filter('a')->attr('href')
          ];
        }

        return $return;

      });

      // Return results for import function
      return $cats;

    }

    // Function to extract large img from wp img link
    private function largeImage($url){

      $originImage = preg_replace('/(-[0-9]+x[0-9]+)+_c/', '', $url);
      if(get_headers($originImage)[0] == 'HTTP/1.1 200 OK')

        // Origin image exists, use that
        return $originImage;

      else{

        // No origin image, extract all sizes and choose the biggest
        preg_match_all('/([0-9]+x[0-9]+)/', $url, $sizes);
        $results = [];
        foreach($sizes[0] as $res){
          $pixs = explode('x', $res);
          $sum = $pixs[0] * $pixs[1];
          $results[$sum] = $res;
        }
        krsort($results);
        $result = reset($results);

        return substr($originImage, 0, -4).'-'.$result.'.jpg';

      }

    }
}
