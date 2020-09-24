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

    private function makeAuthorsSurnames(){
      $authors = Author::get();
      foreach ($authors as $author){

        $split = explode(' ', $author->name);
        $author->surname = last($split);
        // Remove last name from array (which should have a - sign if double surname)
        array_pop($split);

        // Put name back together (double names should be separated by spaces)
        $author->name = implode(' ', $split);

        $author->save();

      }
    }

    private function convertName(){

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

    private function makeThumb(Product $product){

      $currentImage = Voyager::image(json_decode($product->image)[0]);

      $filename = last(explode("/", $currentImage));
      $fileType = last(explode(".", $filename));
      $filePath = explode("/", $currentImage);
      array_pop($filePath); // Remove last (filename)
      array_shift($filePath);array_shift($filePath);array_shift($filePath);array_shift($filePath); // Remove 4 first (https://domain.com/folder/)
      $filePath = implode("/", $filePath);

      $newName = str_replace('.'.$fileType, "", $filename).'-thumb-300.'.$fileType;

      //Check if thumb exists
      if(file_exists(storage_path('app/public/'.$filePath.'/'.$newName)))
        dd('thumb already exists');

      $newImage = Image::make($currentImage);
      $newImage->resize(300, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $newImage->save(storage_path('app/public/'.$filePath.'/'.$newName));

      return back();

    }

    private function makeSlugs(){

      $products = Product::get();
      foreach ($products as $product) {

        if(!$product->slug){
          $product->slug = $product->id.'-'.Str::slug($product->title, '-');
          $product->save();

          echo $product->id.'.'.$product->title.' -> '.$product->slug.'<br>';
        }

        //echo $product->id.'.'.$product->title.' = '.$product->slug.'<br>';

      }

    }

    private function makeThumbs(){
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

    private function importAuthorProducts(){

      $catID = [
        //'grafika' => 11,
        //'tapyba' => 12,
        'klasika' => 13
      ];

      foreach($this->getAuthors() as $cat => $authors){

        echo $cat.'<br>';
        $cat = $catID[$cat];

        foreach($authors as $i => $author){

          //if($i < 11)
            //continue;

          $authorID = Author::where('name', $author['name'])->where('surname', $author['surname'])->first()->id;
          echo $author['name'].' '.$author['surname'].' ('.$authorID.')<br/>';

          $products = $this->getProducts($author['link']);
          foreach($products as $product){

            $this->importProduct($product['title'], $cat, $product['image'], $authorID);

          }

        }

      }

    }

    private function import(){

      //foreach($this->cats() as $cat){

        $cat['title'] = 'Fotografija';
        $cat['link'] = 'https://smallgallery.net/levas-ziriakovas/';

        // Find cat model
        $insertedCat = Category::where('slug', Str::slug($cat['title']))->first();
        if(!$insertedCat){
          dd('cant find cat: '.$cat['title']);
          // Add cat to categories table
          $insertedCat = Category::create([
            'title' => Str::ucfirst($cat['title']),
            'slug' => Str::slug($cat['title'], '-')
          ]);
        }

        // Check if cat has childs (only for foreach loop)
        if(isset($cat['cats'])){
          foreach($cat['cats'] as $subcat){

            $insertedSubcat = Category::where('slug', Str::slug($subcat['title']))->first();
            if(!$insertedSubcat){
              dd('cant find subcat: '.$subcat['title']);
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

          // No child cat - import products
          $products = $this->getProducts($cat['link']);
          foreach($products as $product){
            $this->importProduct($product['title'], $insertedCat->id, $product['image']);
          }
        }

      //}

    }

    private function importProducts(){

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
    private function importProduct($title, $cat, $image, $author = false){

      // Check if product already exists
      $product = Product::where('category_id', $cat)->where('title', $title)->first();
      if(!$product){

        // Insert to database products table
        $inserted = Product::create([
          'title' => $title,
          'category_id' => $cat,
          'author_id' => $author
        ]);

        // Make slug
        $slug = $inserted->id.'-'.Str::slug($title, '-');
        $inserted->slug = $slug;
        $inserted->save();

        // Download product image
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $image);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $img = curl_exec($curl);
        curl_close($curl);

        // Make image name
        $imgExtension = last(explode('.', $image));
        $imgName = '/products/'.$this->catSlug($cat).'/';
        if($author)
          $imgName .= $this->authorSlug($author).'/';
        $imgName .= $slug.'.'.$imgExtension;

        // Save image
        Storage::put('/public'.$imgName, $img);
        $inserted->image = '["'.$imgName.'"]';
        $inserted->save();

        // Create thumb for the product
        $this->makeThumb($inserted);

        echo 'Product imported with ID:'.$inserted->id.'<br>';
      }else
        echo 'Product already exist: '.$product->id.'<br>';

    }

    // Get a list of products with their data from a sub cat or author cat link
    private function getProducts($url = 'https://smallgallery.net/antikvaras/'){

      $client = new Client();

      $crawler = $client->request('GET', $url);

      // Get a list of products
      $products = $crawler->filter('.envira-gallery-item')->each(function($node){

        if($node->filter('.envira-caption')->count())
          $title = $node->filter('.envira-caption')->text();
        else
          $title = '';

        $image = $node->filter('a.envira-gallery-link')->attr('href');

        return [
          'title' => $title,
          'image' => $image
        ];

      });

      return $products;

    }

    private function importAuthors(){

      foreach($this->getAuthors() as $cat){

        foreach($cat as $author){

          $slug = Str::slug($author['name'], '-');

          $findAuthor = Author::where('slug', $slug)->first();
          if(!$findAuthor){
            Author::create([
              'name' => $author['name'],
              'slug' => $slug
            ]);
            echo $author['name'].'('.$slug.') Added to the db<br>';
          }else
            echo $author['name'].'('.$slug.') Already exists<br>';

        }
      }

    }

    // Getting authors from nav
    private function getAuthors(){

      $client = new Client();
      $url = 'https://smallgallery.net/';

      $cats = [
        //'grafika',
        //'tapyba',
        'klasika',
      ];

      // Loop each cat, because each cat has its own authors
      foreach($cats as $cat){
        $crawler = $client->request('GET', $url.$cat);

        // Loop each author
        $author = $crawler->filter('.envira-gallery-item')->each(function($node){

          $name = $node->filter('.envira-album-title')->text();

          // Make surname from full name
          $split = explode(' ', $name);
          $surname = last($split);
          // Remove last name from array (which should have a - sign if double surname)
          array_pop($split);

          // Put name back together (double names should be separated by spaces)
          $name = implode(' ', $split);

          // Return it's info
          return [
            'name' => $name,
            'surname' => $surname,
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

    // Get cat slug from catID (for importProduct function)
    private function catSlug($id){

      $cat = Category::where('id', $id)->first();
      return $cat->slug;

    }

    // Get author slug from authorID (for importProduct function)
    private function authorSlug($id){

      $author = Author::where('id', $id)->first();
      return $author->slug;

    }

}
