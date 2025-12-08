@extends(v_layouts.app) 

@section('content')
    <section class="py-5">
        <div class="container">

            <h2 class="mb-3">Lokasi Toko Komputer Kami</h2>
            <p class="text-muted mb-4">
                Silakan datang langsung ke toko kami pada jam operasional berikut.
            </p>

            <div class="row">
                {{-- Keterangan alamat --}}
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Alamat</h5>
                    <p class="mb-1">Jl. Contoh No. 123</p>
                    <p class="mb-1">Kecamatan Contoh, Kota Contoh</p>
                    <p class="mb-3">Provinsi Contoh, 12345</p>

                    <h6 class="mb-2">Kontak</h6>
                    <p class="mb-1">Telp / WA: 0812-3456-7890</p>
                    <p class="mb-3">Email: tokokomputer@example.com</p>

                    <h6 class="mb-2">Jam Operasional</h6>
                    <ul class="list-unstyled mb-0">
                        <li>Senin – Jumat : 09.00 – 21.00</li>
                        <li>Sabtu – Minggu : 10.00 – 20.00</li>
                    </ul>
                </div>

                {{-- Google Maps --}}
                <div class="col-md-8 mb-4">
                    <div class="ratio ratio-16x9 border">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=<!-- taruh embed map kamu di sini -->"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
