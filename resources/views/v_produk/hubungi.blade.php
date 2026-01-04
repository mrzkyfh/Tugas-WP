@extends('v_layouts.app')
@section('content')

<div class="container" style="max-width:1100px">
  <h3 class="mb-3">Hubungi Kami</h3>

  @php
    $waText = urlencode("Halo, saya mau tanya produk/servis.");
    $waLink = "https://wa.me/{$kontak['wa']}?text={$waText}";
    $mailLink = "mailto:{$kontak['email']}";
    $igLink = "https://instagram.com/{$kontak['ig']}";
  @endphp

  <div class="row g-3">
    <div class="col-lg-6">
      <div class="card" style="border-radius:16px">
        <div class="card-body">
          <h5 class="mb-2">{{ $kontak['nama'] }}</h5>
          <div class="text-muted" style="font-size:14px">{{ $kontak['alamat'] }}</div>

          <div class="mt-3" style="font-size:14px">
            <div><b>WhatsApp:</b> {{ $kontak['telp'] }}</div>
            <div><b>Email:</b> {{ $kontak['email'] }}</div>
            <div><b>Instagram:</b> @{{ $kontak['ig'] }}</div>
          </div>

          <div class="mt-3 d-flex flex-wrap gap-2">
            <a href="{{ $waLink }}" target="_blank" class="btn btn-primary btn-sm">
              Chat WhatsApp
            </a>

            <a href="tel:{{ preg_replace('/\D+/', '', $kontak['telp']) }}" class="btn btn-outline-primary btn-sm">
              Telepon
            </a>

            <a href="{{ $mailLink }}" class="btn btn-outline-primary btn-sm">
              Email
            </a>

            <a href="{{ $igLink }}" target="_blank" class="btn btn-outline-primary btn-sm">
              Instagram
            </a>
          </div>

          <hr class="my-3">

          <div style="font-size:14px" class="text-muted">
            <b>Jam Respon:</b> Senin–Sabtu 09:00–21:00<br>
            (Jika di luar jam, kami balas secepatnya.)
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card h-100" style="border-radius:16px">
        <div class="card-body">
          <h6 class="mb-2">Kirim Pesan Cepat</h6>

          <form onsubmit="return openWhatsAppMessage()">
            <div class="mb-2">
              <label class="form-label" style="font-size:14px">Nama</label>
              <input id="nama" class="form-control" placeholder="Nama kamu" required>
            </div>

            <div class="mb-2">
              <label class="form-label" style="font-size:14px">Pesan</label>
              <textarea id="pesan" class="form-control" rows="4" placeholder="Tulis pesan..." required></textarea>
            </div>

            <button class="btn btn-primary btn-sm" type="submit">Kirim via WhatsApp</button>
          </form>

          <script>
            function openWhatsAppMessage() {
              const nama = document.getElementById('nama').value.trim();
              const pesan = document.getElementById('pesan').value.trim();
              const text = encodeURIComponent(`Halo, saya ${nama}. ${pesan}`);
              window.open(`https://wa.me/{{ $kontak['wa'] }}?text=${text}`, '_blank');
              return false;
            }
          </script>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
