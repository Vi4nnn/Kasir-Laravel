<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" style="background-color: #EEA5A6;">
    <ul class="navbar-nav mr-auto">
       @auth
    @if (session('user_role') == 'admin')
        <li class="nav-item{{ $title == 'Data Jenis Barang' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('jenis-barang') }}">
                <span>Jenis Barang</span>
            </a>
        </li>
        <li class="nav-item{{ $title == 'Data Barang' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('barang') }}">
                <span>Barang</span>
            </a>
        </li>
        <li class="nav-item{{ $title == 'Data User' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('users') }}">
                <span>Data User</span>
            </a>
        </li>
        <li class="nav-item{{ $title == 'Transaksi' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <span>Transaksi</span>
            </a>
        </li>
    @elseif (session('user_role') == 'kasir')
        <li class="nav-item{{ $title == 'Data Jenis Barang' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('jenis-barang') }}">
                <span>Jenis Barang</span>
            </a>
        </li>
        <li class="nav-item{{ $title == 'Data Barang' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('barang') }}">
                <span>Barang</span>
            </a>
        </li>
        <li class="nav-item{{ $title == 'Transaksi' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <span>Transaksi</span>
            </a>
        </li>
    @endif
@endauth

    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ asset('assets/img/boy.png') }}" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">Meong</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#"></a>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<style>
    .active-text {
        background-color: #ffc107; /* Ganti dengan warna latar belakang yang diinginkan */
        color: #000; /* Ganti dengan warna teks yang diinginkan */
        border-radius: 5px; /* Ganti dengan radius sudut yang diinginkan */
        padding: 5px 10px; /* Ganti dengan padding yang diinginkan */
    }
</style>