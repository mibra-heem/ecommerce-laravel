<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Navbar</a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{route('products.index')}}">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('banners*') ? 'active' : '' }}" href="{{route('banners.index')}}">Banner</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}" href="{{route('categories.index')}}">Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('logout') ? 'active' : '' }}" href="#">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>