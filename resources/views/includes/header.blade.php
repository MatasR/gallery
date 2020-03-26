<!-- Navbar -->
<!--<nav class="navbar navbar-light navbar-expand pb-0">
  <a class="navbar-brand" href="#" data-filter="*">
    <img style="width:75px" src="{{ asset('storage/'.setting('site.logo')) }}"/>
  </a>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-secondary" href="/autoriai">Autoriai</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-secondary" href="/apie-mus">Apie mus</a>
    </li>
  </ul>
</nav>-->
<div class="container">
  <nav class="navbar navbar-light justify-content-start px-1">
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler collapsed border-0 mr-3" type="button" data-aos="fade-right" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="bars"></span>
    </button>

    <a class="navbar-brand" href="/">
      <h1 data-aos="fade-down" class="display-4 text-secondary mb-0">
        {{ setting('site.title') }}
      </h1>
    </a>

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
  </nav>
</div>
