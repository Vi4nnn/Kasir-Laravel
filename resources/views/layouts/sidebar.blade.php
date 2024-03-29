<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">RuangAdmin</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    @auth
        @if (session('user_role') == 'admin')
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Data Master
            </div>
            <li class="nav-item {{ $title == 'Data Jenis Barang' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('jenis-barang') }}">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Jenis Barang</span></a>
            </li>
           
            <li class="nav-item  {{ $title == 'Data Barang' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('barang') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Barang</span></a>
            </li>
            <li class="nav-item  {{ $title == 'Data User' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data User</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Transaksi
            </div>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.index') }}">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Transaksi</span></a>
            </li>

           
        @endif

        @if (session('user_role') == 'kasir')
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Transaksi
            </div>
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Transaksi</span></a>
            </li>
        @endif
    @endauth
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
