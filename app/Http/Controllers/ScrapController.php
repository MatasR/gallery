<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScrapController extends Controller
{
    private function largeImage($url){

      return preg_replace('/(-[0-9]+x[0-9]+)+_c/', '', $url);

    }

    // Get a list of products with their data from a sub cat or author cat link
    public function products(){

      $client = new Client();
      $url = 'https://smallgallery.net/envira/inga-darguzyte/';

      $crawler = $client->request('GET', $url);

      // Get a list of products
      $products = $crawler->filter('.envira-gallery-item')->each(function($node){

        if($node->filter('.envira-caption')->count())
          $title = $node->filter('.envira-caption')->text();
        else
          $title = '';

        $image = $this->largeImage($node->filter('a img')->attr('src'));

        return [
          'title' => $title,
          'image' => $image
        ];

      });

      dd($products);

    }

    // Getting authors from nav
    public function authors(){

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

      dd($authors);

    }

    // Getting cats from nav
    public function cats(){

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

      dd($cats);

    }
}
