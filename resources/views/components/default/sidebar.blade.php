<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">TOKO NAYLA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">inventory</a>
        </div>

        <ul class="sidebar-menu">

            <li class="menu-header">Dashboard</li>

            <li class="nav-item">
                <a href="/dashboard" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item dropdown {{ request()->routeIs('admin.*', 'base.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-sitemap"></i>
                    <span>Master Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.barang') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.barang') }}">
                            Data Barang
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.rak') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.rak') }}">
                            Rak Barang
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('base.transaksi') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('base.transaksi') }}">
                            Laporan Penjualan
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.riwayat') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.riwayat') }}">
                            Riwayat Pemesanan Ulang
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <form action="{{ route('admin.logout') }}" method="POST" class="d-grid p-3">
            @csrf
            <button type="submit" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </aside>
</div>
