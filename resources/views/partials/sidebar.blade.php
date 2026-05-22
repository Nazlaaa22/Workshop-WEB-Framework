<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- PROFILE --}}
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/image.jpg') }}" />
                    <span class="login-status online"></span>
                </div>

                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">
                        {{ Auth::check() ? Auth::user()->name : 'Admin RS' }}
                    </span>

                    <span class="text-secondary text-small">
                        {{ Auth::check() ? (Auth::user()->role ?? 'Admin') : 'Admin RS' }}
                    </span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>


        {{-- ================= ADMIN ================= --}}
        @if(auth()->check() && auth()->user()->role == NULL)
        <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kategori.index') }}">
                <span class="menu-title">Kategori</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('buku.index') }}">
                <span class="menu-title">Buku</span>
                <i class="mdi mdi-book menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('barang.index') }}">
                <span class="menu-title">Barang UMKM</span>
                <i class="mdi mdi-cart-outline menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('barang-js') ? 'active' : '' }}">
            <a class="nav-link" href="/barang-js">
                <span class="menu-title">Data Barang JS</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('barang-js/datatables') ? 'active' : '' }}">
            <a class="nav-link" href="/barang-js/datatables">
                <span class="menu-title">Data Barang JS Datatable</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kota') ? 'active' : '' }}">
            <a class="nav-link" href="/kota">
                <span class="menu-title">Select Kota</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('wilayah*') ? 'active' : '' }}">
            <a class="nav-link" href="/wilayah">
                <span class="menu-title">Wilayah Indonesia AJ</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('wilayah*') ? 'active' : '' }}">
            <a class="nav-link" href="/wilayah">
                <span class="menu-title">Wilayah Indonesia AX</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/pos">
                <span class="menu-title">POS AJAX</span>
                <i class="mdi mdi-cash-register menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/pos-axios">
                <span class="menu-title">POS AXIOS</span>
                <i class="mdi mdi-cash-register menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#pdfMenu">
                <span class="menu-title">Generate PDF</span>
                <i class="mdi mdi-file-pdf-box menu-icon"></i>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pdfMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/pdf-sertifikat') }}">
                            Sertifikat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/pdf-undangan') }}">
                            Undangan
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/vendor">
                <span class="menu-title">Kelola Vendor</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#customerMenu" role="button" aria-expanded="false" aria-controls="customerMenu">
                <span class="menu-title">Customer</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>

            <div class="collapse" id="customerMenu">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/customer">
                            Data Customer
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/customer/create1">
                            Tambah Customer (BLOB)
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/customer/create2">
                            Tambah Customer (FILE)
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/barcode-scanner">
                <span class="menu-title">Scan Barcode</span>
                <i class="mdi mdi-barcode-scan menu-icon"></i>
            </a>
        </li>
        @endif


        {{-- ================= VENDOR ================= --}}
        @if(auth()->check() && auth()->user()->role == 'vendor')

        <li class="nav-item">
            <a class="nav-link" href="/vendor-dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/menu">
                <span class="menu-title">Menu Saya</span>
                <i class="mdi mdi-food menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/pesanan">
                <span class="menu-title">Pesanan Lunas</span>
                <i class="mdi mdi-cash-check menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/vendor-scan-qr">
                <span class="menu-title">Scan QR</span>
                <i class="mdi mdi-qrcode-scan menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/kunjungan-toko') }}">
                <span class="menu-title">Kunjungan Toko</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
        </li>

        @endif

        {{-- ================= ADMIN RS ================= --}}
        @if(auth()->check() && auth()->user()->role == 'adminRS')

        <li class="nav-item">
            <a class="nav-link" href="/admin-dashboard">
                <span class="menu-title">Dashboard RS</span>
                <i class="mdi mdi-hospital-building menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/guest">
                <span class="menu-title">Pendaftaran Pasien</span>
                <i class="mdi mdi-account-plus menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/papan-antrian">
                <span class="menu-title">Papan Antrian</span>
                <i class="mdi mdi-monitor-dashboard menu-icon"></i>
            </a>
        </li>

        @endif

    </ul>
</nav>