<!-- Navbar -->
<div class="container">
  <nav class="navbar navbar-light justify-content-start justify-content-sm-center justify-content-md-start px-1">
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler collapsed border-0 mr-2" type="button" data-aos="fade-right" data-toggle="collapse" data-target="#collapsibleNavbar">
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
    <form class="form-inline ml-md-auto" id="main-search">
      <div class="input-group">
        <input id="wrapped" class="form-control" type="search" placeholder="Paieška" aria-label="Search" autocomplete="off">
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
    $(window).on('load', function () {

      $('#main-search input').autoComplete({
        resolver: 'custom',
        formatResult: function(item){
          return item;
        },
        events: {
          search: function(query, callback, origJQElement){
            var type = origJQElement.parent().find('select').val();
            $.ajax({
              type: 'POST',
              url: '/ajax/main-search',
              data: {
                '_token': $('meta[name="_token"]').attr('content'),
                'searchInput': query,
                'searchType': type
              },
              success: function(data){
                callback(data);
              }
            });
          },
          searchPost: function(resultsFromServer, el) {
            /*console.log(el.parent().width());
            el.parent().find('.bootstrap-autocomplete').width(el.parent().width());
            console.log(el.parent().find('.bootstrap-autocomplete').width());*/
            return resultsFromServer;
          }
        }
      });

      // Redirect on suggestion click
      $('#main-search').on('autocomplete.select', function(event, item){
        window.location.href = item.url;
      });

    });
  </script>
@endpush
