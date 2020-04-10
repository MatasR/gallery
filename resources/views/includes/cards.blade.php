@foreach($category->products->skip($perPage*$page)->take($perPage)->merge($category->childs_products) as $product)
  <div data-aos=fade-up id="{{ $product->id }}" class="card text-white text-center border-0 {{ ($product->category->parent?$product->category->parent->slug:'') }} {{ $product->category->slug }}">
    <img class="card-img" src="{{ asset('storage'.json_decode($product->images)[0]) }}"/>
  </div>
@endforeach
