@extends('v_layouts.app')
@section('content')
<!-- template -->

<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="billing-details">
            <div class="section-title">
                <h3 class="title">{{ $judul }} </h3>
            </div>
        </div>
    </div>

<!--  Product Details -->
<div class="product-detail-card">

    <!-- LEFT : Gambar Produk -->
    <div class="detail-gallery">

        <div class="detail-image-main">
            <img src="{{ asset('storage/img-produk/thumb_lg_' . $row->foto) }}" alt="">
        </div>

        <div class="detail-thumb-list">
            <img src="{{ asset('storage/img-produk/thumb_sm_' . $row->foto) }}" class="thumb-active">

            @foreach ($fotoProdukTambahan as $item)
                @if ($item->produk_id == $row->id)
                    <img src="{{ asset('storage/img-produk/' . $item->foto) }}">
                @endif
            @endforeach
        </div>

    </div>

    <!-- RIGHT : Detail -->
    <div class="detail-info">

        <div class="detail-meta">
            <span class="badge-cat">{{ $row->kategori->nama_kategori }}</span>
            <span class="badge-stock">
                Stok : {{ $row->stok }}
            </span>
        </div>

        <h1 class="detail-title">{{ $row->nama_produk }}</h1>

        <div class="detail-price">
            Rp. {{ number_format($row->harga, 0, ',', '.') }}
        </div>

        <p class="detail-desc">
            {!! $row->detail !!}
        </p>

        <ul class="detail-attr">
            <li><strong>Berat</strong> {{ $row->berat }} Gram</li>
        </ul>

        <form action="{{ route('order.addToCart', $row->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-primary-pill">
                <i class="fa fa-shopping-cart"></i> Pesan Sekarang
            </button>
        </form>

    </div>

</div>
<!-- /Product Details -->

</div>
<!-- /Product Details -->

<!-- end template-->
@endsection