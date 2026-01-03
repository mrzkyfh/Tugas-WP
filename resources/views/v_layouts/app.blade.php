<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logos.png') }}">
    <title>toko komputer</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css') }}">

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

</head>

<body>
    <!-- HEADER -->
<header class="site-header">
    <!-- top Header -->
    <div id="top-header" class="header-top">
        <div class="container">
            <div class="top-header-left">
                <i class="fa fa-desktop"></i>
                <span>Selamat datang di <strong>toko komputer</strong></span>
            </div>
            <div class="top-header-right">
                <i class="fa fa-whatsapp"></i>
                <span> 08xx-xxxx-xxxx</span>
                <span class="top-header-divider"></span>
                <i class="fa fa-truck"></i>
                <span> Pengiriman cepat area Jabodetabek</span>
            </div>
        </div>
    </div>
    <!-- /top Header -->

    <!-- header main -->
    <div id="header" class="header-main">
        <div class="container header-main-inner">
            <div class="header-left">
                <!-- Logo + nama toko -->
                <div class="header-logo">
                    <a class="logo" href="{{ route('beranda') }}">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo toko komputer">
                    </a>
                    <div class="brand-text">
                        <span class="brand-name">Toko Komputer</span>
                        <span class="brand-tagline">Perangkat lengkap untuk kebutuhan digital Anda</span>
                    </div>
                </div>
                <!-- /Logo -->
            </div>

            <div class="header-right">
                <ul class="header-btns">
                    <!-- Cart -->
                    <li class="header-cart dropdown modern-header-btn">
                        <a href="{{ route('order.cart') }}" class="header-btn-link">
                            <div class="header-btns-icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="header-btns-text">
                                <span class="label">Keranjang</span>
                                <span class="sub">Lihat pesanan Anda</span>
                            </div>
                        </a>
                    </li>
                    <!-- /Cart -->

                    <!-- Account -->
                    @if (Auth::check())
                        <li class="header-account dropdown modern-header-btn">
                            <a href="#" class="dropdown-toggle header-btn-link" data-toggle="dropdown"
                               role="button" aria-expanded="true">
                                <div class="header-btns-icon">
                                    <i class="fa fa-user-o"></i>
                                </div>
                                <div class="header-btns-text">
                                    <span class="label">{{ Auth::user()->nama }}</span>
                                    <span class="sub">Akun saya</span>
                                </div>
                                <i class="fa fa-caret-down caret-icon"></i>
                            </a>
                            <ul class="custom-menu">
                                {{-- TODO: sesuaikan route halaman profil/akun --}}
                                <li><a href="#"><i class="fa fa-user-o"></i> Akun Saya</a></li>
                                <li><a href="{{ route('order.history') }}"><i class="fa fa-check"></i> History</a></li>
                                <li>
                                    <a href="#"
                                       onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
                                        <i class="fa fa-power-off"></i> Keluar
                                    </a>
                                    <form id="keluar-app" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="header-account modern-header-btn">
                            <a href="{{ route('auth.redirect') }}" class="header-btn-link">
                                <div class="header-btns-icon">
                                    <i class="fa fa-user-o"></i>
                                </div>
                                <div class="header-btns-text">
                                    <span class="label">Akun Saya</span>
                                    <span class="sub">Login / Daftar</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    <!-- /Account -->

                    <!-- Mobile nav toggle-->
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn">
                            <i class="fa fa-bars"></i>
                        </button>
                    </li>
                    <!-- / Mobile nav toggle -->
                </ul>
            </div>
        </div>
    </div>
    <!-- /header main -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->
<div id="navigation" class="main-nav">
    <div class="container">
        <div id="responsive-nav">
            @php
                $kategori = DB::table('kategori')->orderBy('nama_kategori', 'asc')->get();
            @endphp

            @if (request()->segment(1) == '' || request()->segment(1) == 'beranda')
                <!-- category nav -->
                <div class="category-nav">
                    <span class="category-header">
                        <i class="fa fa-list"></i>
                        Kategori
                    </span>
                    <ul class="category-list">
                        @foreach ($kategori as $row)
                            <li>
                                <a href="{{ route('produk.kategori', $row->id) }}">
                                    {{ $row->nama_kategori }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /category nav -->
            @endif

            <!-- menu nav -->
            <div class="menu-nav">
                <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
                <ul class="menu-list">
                    <li><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li><a href="{{ route('produk.all') }}">Produk</a></li>
                    <li><a href="{{ route('lokasi') }}">Lokasi</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                </ul>
            </div>
            <!-- /menu nav -->
        </div>
    </div>
</div>
<!-- /NAVIGATION -->


    @if (request()->segment(1) == '' || request()->segment(1) == 'beranda')
    <div id="home">
        <!-- container -->
        <div class="container">
            <!-- home wrap -->
            <div class="home-wrap">
                <!-- home slick -->
                <div id="home-slick">
                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('frontend/banner/banner01.jpg') }}" alt="">
                        <div class="banner-caption text-center">
                            <h1>menjual seluruh perangkat komputer</h1>
                            <h3 class="font-weak" style="color: 30323a;">toko komputer</h3>
                            <button class="primary-btn">Pesan Sekarang</button>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('frontend/banner/banner02.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="primary-color">menjual seluruh perangkat komputer<br><span class="white-color font-weak">toko komputer</span></h1>
                            <button class="primary-btn">Pesan Sekarang</button>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('frontend/banner/banner03.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 style="color: f8694a;">toko komputer <span>Indonesia</span></h1>
                            <button class="primary-btn">Pesan Sekarang</button>
                        </div>
                    </div>
                    <!-- /banner -->
                </div>
                <!-- /home slick -->
            </div>
            <!-- /home wrap -->
        </div>
        <!-- /container -->
    </div>
    @endif

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">PRODUK TERLARIS</h3>
                        <!-- widget product -->
                        <div class="product product-widget">
                            <div class="product-thumb">
                                <img src="{{ asset('frontend/img/thumb-product01.jpg') }}" alt="">
                            </div>
                            <div class="product-body">
                                <h2 class="product-name"><a href="{{ route('produk.all') }}">keyboard acus</a></h2>
                                <h3 class="product-price">Rp.350.000 <del class="product-old-price">Rp.450.000</del></h3>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o empty"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /widget product -->

                        <!-- widget product -->
                        <div class="product product-widget">
                            <div class="product-thumb">
                                <img src="{{ asset('frontend/img/thumb-product02.jpg') }}" alt="">
                            </div>
                            <div class="product-body">
                                <h2 class="product-name"><a href="#">Mouse Razer</a></h2>
                                <h3 class="product-price">Rp.200.000 <del class="product-old-price">Rp.350.000</del></h3>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /widget product -->
                    </div>
                    <!-- /aside widget -->
                    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">Filter Kategori</h3>
                        <ul class="list-links">
                            @foreach ($kategori as $row)
                            <li><a href="{{ route('produk.kategori', $row->id) }}">{{ $row->nama_kategori }}</a></li>
                            @endforeach
                        </ul>

                    </div>
                    <!-- /aside widget -->
                </div>
                <!-- /ASIDE -->

                <!-- MAIN -->
                <div id="main" class="col-md-9">
                    <!-- store top filter -->
                    <!-- /store top filter -->

                    <!-- @yieldAwal -->
                    @yield('content')
                    <!-- @yieldAkhir-->

                    <!-- store bottom filter -->

                    <!-- /store bottom filter -->
                </div>
                <!-- /MAIN -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- FOOTER -->
    <footer id="footer" class="section section-grey">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- footer widget -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="footer">
                        <!-- footer logo -->
                        <div class="footer-logo">
                            <a class="logo" href="#">
                                <img src="./img/logo.png" alt="">
                            </a>
                        </div>
                        <!-- /footer logo -->

                        <p>“Power Up & Stay Connected — Temukan semua kebutuhan teknologi Anda di sini!”</p>

                        <!-- footer social -->
                        <ul class="footer-social">
                            <li><a href="https:facebook.com"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https:twitter.com"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="https:instagram.com"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="https:id.pinterest.com"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                        <!-- /footer social -->
                    </div>
                </div>
                <!-- /footer widget -->

                <!-- footer widget -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-header">Akun Saya</h3>
                        <ul class="list-links">
                            <li><a href="#">Akun Saya</a></li>
                            <li><a href="#">Daftar Keinginan Saya</a></li>
                            <li><a href="#">Membandingkan</a></li>
                            <li><a href="{{ route('order.cart')}}">Check-out</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /footer widget -->

                <div class="clearfix visible-sm visible-xs"></div>

                <!-- footer widget -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-header">Pelayanan pelanggan</h3>
                        <ul class="list-links">
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="#">Pengiriman & Pengembalian</a></li>
                            <li><a href="#">SPanduan Pengiriman</a></li>
                            <li><a href="#">Pertanyaan Umum</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /footer widget -->

                <!-- footer subscribe -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-header">Tetap Terhubung</h3>
                        <p>“Power Up & Stay Connected — Temukan semua kebutuhan teknologi Anda di sini!”</p>
                        <form>
                            <div class="form-group">
                                <input class="masukan" placeholder="Masukkan Alamat Email">
                            </div>
                            <button class="primary-btn">Bergabunglah</button>
                        </form>
                    </div>
                </div>
                <!-- /footer subscribe -->
            </div>
            <!-- /row -->
            <hr>
            <!-- row -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <!-- footer copyright -->
                    <div class="footer-copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | TERIMA KASIH TELAH MENGUNJUNGI SITUS KAMI <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">TK</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                    <!-- /footer copyright -->
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>

</html>