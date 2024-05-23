<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Dashboard</div>
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route("admin.dashboard") }}" >
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboards
                </a>
                <div class="sidenav-menu-heading">Produk</div>
                <a class="nav-link {{ request()->is('admin/produk/list_produk') ? 'active' : '' }}" href="{{route("admin.produk.list")}}">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    List Produk
                </a>
                <div class="sidenav-menu-heading">Transaksi</div>
                <a class="nav-link {{ request()->is('admin/transaksi/penjualan/list_penjualan') ? 'active' : '' }}" href="{{route("admin.transaksi.penjualan.list")}}">
                    <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                    Penjualan
                </a>
                <a class="nav-link {{ request()->is('admin/transaksi/pembelian/list_pembelian') ? 'active' : '' }} " href="{{route("admin.transaksi.pembelian.list")}}">
                    <div class="nav-link-icon"><i data-feather="refresh-ccw"></i></div>
                    Pembelian
                </a>
                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                    <div class="nav-link-icon"><i data-feather="package"></i></div>
                    Stok
                </a>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">
                    <div class="sidenav-footer-title-text">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </div>
    </nav>
</div>