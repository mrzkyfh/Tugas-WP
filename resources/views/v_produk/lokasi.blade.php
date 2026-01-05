@extends('v_layouts.app')
@section('content')

<div class="container" style="max-width:1100px">
  <h3 class="mb-3">Lokasi Toko</h3>

  <div class="row g-3">

    {{-- ===================== LIST KIRI ===================== --}}
    <div class="col-lg-5">

      @forelse($lokasi as $toko)
        @php
          $directions = "https://www.google.com/maps/dir/?api=1&destination={$toko->lat},{$toko->lng}";
        @endphp

        <div class="card mb-3" style="border-radius:16px">
          <div class="card-body">
            <b>{{ $toko->nama }}</b>

            <div class="text-muted" style="font-size:14px">
              {{ $toko->alamat }}
            </div>

            <div style="font-size:14px">Jam: {{ $toko->jam ?? '-' }}</div>
            <div style="font-size:14px">Telp/WA: {{ $toko->telp ?? '-' }}</div>

            <div class="mt-2 d-flex gap-2">
              <a href="{{ $directions }}" target="_blank" class="btn btn-sm btn-primary">
                Petunjuk Arah
              </a>

              <button type="button" class="btn btn-sm btn-outline-primary"
                onclick="focusMap(
                  {{ $toko->lat }},
                  {{ $toko->lng }},
                  @js($toko->nama),
                  @js($toko->alamat),
                  @js($toko->jam ?? '-'),
                  @js($toko->telp ?? '-')
                )">
                Lihat di Peta
              </button>
            </div>
          </div>
        </div>
      @empty
        <div class="alert alert-warning">
          Lokasi toko belum ada / belum aktif.
          <br><small>Cek tabel <b>lokasi</b> dan kolom <b>is_active</b> = 1</small>
        </div>
      @endforelse

    </div>

    {{-- ===================== MAP KANAN ===================== --}}
    <div class="col-lg-7">
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
      <div id="map" style="height:520px;border-radius:16px;overflow:hidden;"></div>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

      <script>
        // Ambil data dari Laravel ke JS (AMAN)
        const lokasi = @json($lokasi);

        // Fallback kalau data kosong
        const first = lokasi[0] ?? { lat: -6.6, lng: 106.9 };

        // Init map
        const map = L.map('map').setView(
          [parseFloat(first.lat), parseFloat(first.lng)],
          12
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19
        }).addTo(map);

        // Marker semua lokasi
        lokasi.forEach(t => {
          if (!t.lat || !t.lng) return;

          L.marker([parseFloat(t.lat), parseFloat(t.lng)]).addTo(map)
            .bindPopup(
              `<b>${t.nama}</b><br>${t.alamat}
               <br><small>Jam: ${t.jam ?? '-'} | Telp/WA: ${t.telp ?? '-'}</small>`
            );
        });

        // Fokus map dari tombol
        function focusMap(lat, lng, nama, alamat, jam = '-', telp = '-') {
          map.setView([lat, lng], 16);

          L.popup()
            .setLatLng([lat, lng])
            .setContent(
              `<b>${nama}</b><br>${alamat}
               <br><small>Jam: ${jam} | Telp/WA: ${telp}</small>`
            )
            .openOn(map);
        }
      </script>
    </div>

  </div>
</div>

@endsection
