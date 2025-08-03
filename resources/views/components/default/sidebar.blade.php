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

            <li class="nav-item  ">
                <a href="/dashboard" class="nav-link "><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i>
                        <span>Master Data</span></a>
                    <ul class="dropdown-menu">

                        <li>
                            <a class="nav-link" href="{{route('admin.barang')}}">
                                Data Barang
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{route('admin.rak')}}">
                                Rak Barang
                            </a>
                        </li>
                        
                        <li>
                            <a class="nav-link" href="{{route('base.transaksi')}}">
                                Laporan penjualan
                            </a>
                        </li>
                        
                        <li>
                            <a class="nav-link" href="{{route('admin.riwayat')}}">
                                Riwayat pemesanan ulang
                            </a>
                        </li>
                    </ul>
                </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i>Logout
            </a>
        </div>
    </aside>
</div>