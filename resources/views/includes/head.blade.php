<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="_token" content="{{ csrf_token() }}"/>

@include('meta::manager', [
    'title'         => (isset($product)?$product->title.' | ':'').(!isset($initCategory)?(isset($cat)?$cat->title.' | ':''):'').setting('site.title'),
    'title'         => (isset($pageTitle)?$pageTitle.' | ':'').setting('site.title'),
    'description'   => (isset($product->description)?$product->description:setting('site.description')),
    'image'         => (isset($product->image)?Voyager::image(json_decode($product->image)[0]):setting('site.logo'))
])

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
