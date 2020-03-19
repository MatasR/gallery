<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
        <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                /*align-items: center;*/
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                cursor: pointer;
            }
            .description {
                font-size: 24px;
            }

            .links a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .submenu {
                display: inline-block;
                position: relative;
            }
            .submenu-items {
                display: none;
                position: absolute;
                background: #fff;
                border: 1px solid #ccc;
                z-index: 1;
                width: 100%;
            }
            .submenu-items a {
                display: block;
                margin: 5px 0;
            }
            .submenu:hover {

            }
            .submenu:hover .submenu-items {
                display: block;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .grid {
                margin-top: 20px;
            }
            .grid-item {
                position: relative;
            }
            .grid-item img {
                max-width: 100%;
                display: block;
            }
            .grid-item .name {
                position: absolute;
                bottom: 0;
                width: 100%;
                text-align: center;
                font-size: 48px;
                background: rgba(0, 0, 0, 0.3);
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

          <div class="top-right links">
            <a href="apie">Apie mus</a>
          </div>

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title">
                    <a data-filter="*">{{ setting('site.title') }}</a>
                </div>

                @if(setting('site.description') != '')
                  <div class="description m-b-md">
                      {{setting('site.description')}}
                  </div>
                @endif

                <div class="links">
                    @foreach(App\Category::get()->where('parent_id', '') as $category)
                      @if($category->childs->count())
                        <div class="submenu">
                          <a href="#{{ $category->slug }}" data-filter=".{{ $category->slug }}">{{ $category->title }}</a>
                          <div class="submenu-items">
                            @foreach($category->childs as $child)
                              <a href="#{{ $child->slug }}" data-filter=".{{ $child->slug }}">{{ $child->title }}</a>
                            @endforeach
                          </div>
                        </div>
                      @else
                        <a href="#{{ $category->slug }}" data-filter=".{{ $category->slug }}">{{ $category->title }}</a>
                      @endif
                    @endforeach
                </div>

                <div class="grid">
                  @foreach(App\Product::get() as $product)
                    <div class="grid-item {{ ($product->category->parent?$product->category->parent->slug:'') }} {{ $product->category->slug }}">
                      <div class="name">
                        {{ $product->title }}
                      </div>
                      <img src="{{ asset('storage/'.$product->image->src) }}"/>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
        <script>
        var $grid = $('.grid').isotope({
          // options
          itemSelector: '.grid-item'
        });

        $('.links, .title').on('click', 'a', function(){
          var filterValue = $(this).attr('data-filter');
          $grid.isotope({ filter: filterValue });
        });
        </script>
    </body>
</html>
