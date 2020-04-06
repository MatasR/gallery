<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScrapController extends Controller
{
    // Getting cats from nav
    public function index(){

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
