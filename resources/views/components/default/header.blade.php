<style>
    .navbar-bg {
        background-color: #d20870 !important; /* Warna background atas */
        height: 70px;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: -1;
    }

    .main-navbar {
        background-color: #47db12 !important; /* Warna navbar */
        box-shadow: 0 2px 6px rgba(0,0,0,.1);
    }

    .main-navbar .nav-link,
    .main-navbar .navbar-nav .nav-link-user {
        color: #ffffff !important; /* Warna teks putih */
    }

    .main-navbar .nav-link:hover {
        color: #f8f9fa !important;
    }
</style>

<div class="navbar-bg"></div>

<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image"
                     src="{{ secure_asset('img/avatar/avatar-1.png') }}"
                     class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    {{ Auth::user()->name }}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

                <form id="logout-form"
                      action="{{ route('admin.logout') }}"
                      method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>