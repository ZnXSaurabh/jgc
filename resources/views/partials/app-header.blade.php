<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><img src="{{ asset('front/images/icon.png') }}" alt="" /></a></li>
        <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}"><img style="width: 13%" alt="JGC Gulf International." src="{{ asset('images/site-icon.jpg') }}">
        <h3 class="brand-text"> Gulf International</h3></a></li>
        <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="18px" height="18px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M17 6H7c-3.31 0-6 2.69-6 6s2.69 6 6 6h10c3.31 0 6-2.69 6-6s-2.69-6-6-6zm0 10H7c-2.21 0-4-1.79-4-4s1.79-4 4-4h10c2.21 0 4 1.79 4 4s-1.79 4-4 4zM7 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></i></a></li>
        <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="material-icons mt-50">more_vert</i></a></li>
      </ul>
    </div>
    <div class="navbar-container content">
      <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
          <li class="nav-item nav-search">
            <!-- <a class="nav-link nav-link-search" href="#"><i class="material-icons">search</i></a> -->
            <div class="search-input">
              <input class="input round form-control search-box" type="text" placeholder="Explore Modern Admin" tabindex="0" data-search="template-list">
              <div class="search-input-close"><i class="ft-x"></i></div><ul class="search-list"></ul>
              <div class="dropdown-menu arrow">
                <div class="dropdown-item">
                  <input class="round form-control" type="text" placeholder="Search Here">
                </div>
              </div>
            </div>
          </li>
        </ul>
        <ul class="nav navbar-nav float-right">
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700">Hello {{ Auth::user()->name }}</span><span class="avatar avatar-online"><img src="{{ asset('app-assets/images/avatar.png') }}" alt="avatar"><i></i></span></a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- <a class="dropdown-item" href="#"><i class="material-icons">person_outline</i> Edit Profile</a> -->
              <!-- <div class="dropdown-divider"></div> -->
              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="material-icons">power_settings_new</i> {{ trans('global.logout') }}</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>