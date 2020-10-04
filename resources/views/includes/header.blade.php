<!-- Navbar -->
<div class="container">
  <nav class="navbar navbar-light justify-content-start px-1">
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler collapsed border-0 mr-3" type="button" data-aos="fade-right" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="bars"></span>
    </button>

    <!-- Logo -->
    <a class="navbar-brand" href="/">
      <h1 data-aos="fade-down" class="display-4 text-secondary mb-0">
        {{ setting('site.title') }}
      </h1>
    </a>

    <!-- Left menu -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/autoriai">
            Autoriai
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/apie-mus">
            Apie mus
          </a>
        </li>
      </ul>
    </div>

    <!-- Search bar -->
    <form class="form-inline ml-auto" id="main-search">
      <div class="input-group">
        <input id="wrapped" class="form-control" type="search" placeholder="Paieška" aria-label="Search">
        <div class="input-group-addon">
          <select class="form-control">
            <option value="authors">Authors</option>
            <option value="products">Products</option>
            <option value="categories">Categories</option>
          </select>
        </div>
      </div>
    </form>
  </nav>
</div>

@push('scripts')
  <script type="text/javascript">
    // Main search
    $(document).ready(function(){
      var searchType = $('#main-search select').val();
      $('#main-search input').autocomplete({
        serviceUrl: '/ajax/main-search',
        params: searchType,
        onSelect: function(suggestion){
          console.log(suggestion)
        }
      });
    });
    /*$(window).on('load', function () {
      $('#main-search input').on('keyup', function(){

        var value = $(this).val().toLowerCase();
        var type = $(this).parent().find('select').val();
        $.ajax({
          type: 'POST',
          url: '/ajax/main-search',
          data: {
            '_token': $('meta[name="_token"]').attr('content'),
            'searchInput': value,
            'searchType': type
          },
          success: function(data) {
            console.log(data);
          }
        });

      });
    });*/
  </script>
@endpush
