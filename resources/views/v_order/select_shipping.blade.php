@extends('v_layouts.app')
@section('content')
<!-- template -->

<div class="col-md-12" hidden>
    <div class="order-summary clearfix">
        <div class="section-title">
            <p>PENGIRIMAN</p>
            <h3 class="title">Produk</h3>
        </div>
        @if($order && $order->orderItems->count() > 0)
        <table class="shopping-cart-table table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th></th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalHarga = 0;
                $totalBerat = 0;
                @endphp
                @foreach($order->orderItems as $item)
                @php
                $totalHarga += $item->harga * $item->quantity;
                $totalBerat += $item->produk->berat * $item->quantity;
                @endphp
                <tr>
                    <td class="thumb"><img src="{{ asset('storage/img-produk/thumb_sm_' . $item->produk->foto) }}" alt=""></td>
                    <td class="details">
                        <a>{{ $item->produk->nama_produk }}</a>
                        <ul>
                            <li><span>Berat: {{ $item->produk->berat }} Gram</span></li>
                        </ul>
                        <ul>
                            <li><span>Stok: {{ $item->produk->stok }} Gram</span></li>
                        </ul>
                    </td>
                    <td class="price text-center"><strong>Rp. {{ number_format($item->harga, 0, ',', '.') }}</strong></td>
                    <td class="qty text-center">
                        <a> {{ $item->quantity }} </a>
                    </td>
                    <td class="total text-center"><strong class="primary-color">Rp. {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Keranjang belanja kosong.</p>
        @endif
    </div>
</div>

<div class="col-md-12">
    <div class="order-summary clearfix">
        <div class="section-title">
            <p>PENGIRIMAN</p>
            <h3 class="title">Pilih Pengiriman</h3>
        </div>
        <form id="shippingForm">
            <!-- Kota Asal -->
            <input type="hidden" id="city_origin" name="city_origin" value="">
            <input type="hidden" id="city_origin_name" name="city_origin_name" value="">
            <!-- /Kota Asal -->

            <div class="form-group">
                <label for="province">Provinsi Tujuan:</label>
                <select name="province" id="province" class="input">
                    <option value="">Pilih Provinsi Tujuan</option>
                    <!-- Data Provinsi Tujuan akan dimuat dengan JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="city">Kota Tujuan:</label>
                <select name="city" id="city" class="input">
                    <option value="">Pilih Kota Tujuan</option>
                    <!-- Data Kota Tujuan akan dimuat dengan JavaScript -->
                </select>
            </div>
            <input type="hidden" name="weight" id="weight" value="{{ $totalBerat }}">
            <input type="hidden" name="province_name" id="province_name">
            <input type="hidden" name="city_name" id="city_name">
            <div class="form-group">
                <label for="courier">Kurir:</label>
                <select name="courier" id="courier" class="input">
                    <option value="">Pilih Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="tiki">TIKI</option>
                    <option value="pos">POS Indonesia</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Alamat</label>
                <textarea class="input" name="alamat" id="alamat">{{ Auth::user()->alamat }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Kode Pos</label>
                <input type="text" class="input" name="kode_pos" id="kode_pos" value="{{ Auth::user()->pos }}">
            </div>
            <button type="submit" class="primary-btn">Cek Ongkir</button>
        </form>

        <br>
        <div id="result">
            <table class="shopping-cart-table table">
                <thead>
                    <tr>
                        <th>Layanan</th>
                        <th>Biaya</th>
                        <th>Estimasi Pengiriman</th>
                        <th>Total Berat</th>
                        <th>Total Harga</th>
                        <th>Bayar</th>
                    </tr>
                </thead>
                <tbody id="shippingResults">
                    <!-- Hasil dari pencarian akan dimuat di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ================== KOTA ASAL (TETAP) ==================
        const originCityCode = 115; // Depok (contoh)
        const originCityName = 'Depok';

        document.getElementById('city_origin').value = originCityCode;
        document.getElementById('city_origin_name').value = originCityName;

        // ================== DATA ONGKIR MANUAL JABODETABEK ==================
        const shippingData = {
            "DKI Jakarta": [
                { city: "Jakarta Pusat", price: 10000 },
                { city: "Jakarta Utara", price: 10000 },
                { city: "Jakarta Selatan", price: 10000 },
                { city: "Jakarta Timur", price: 10000 },
                { city: "Jakarta Barat", price: 10000 },
                { city: "Kepulauan Seribu", price: 12000 },
            ],
            "Jawa Barat": [
                { city: "Kota Depok", price: 12000 },
                { city: "Kota Bogor", price: 15000 },
                { city: "Kabupaten Bogor", price: 16000 },
                { city: "Kota Bekasi", price: 13000 },
                { city: "Kabupaten Bekasi", price: 14000 },
            ],
            "Banten": [
                { city: "Kota Tangerang", price: 13000 },
                { city: "Kota Tangerang Selatan", price: 13000 },
                { city: "Kabupaten Tangerang", price: 14000 },
            ],
        };

        // ================== ELEMENT FORM ==================
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const shippingForm = document.getElementById('shippingForm');
        const shippingResults = document.getElementById('shippingResults');

        const provinceNameInput = document.getElementById('province_name');
        const cityNameInput = document.getElementById('city_name');
        const weightInput = document.getElementById('weight');
        const alamatInput = document.getElementById('alamat');
        const kodePosInput = document.getElementById('kode_pos');

        // ================== ISI PROVINSI MANUAL ==================
        provinceSelect.innerHTML = '<option value="">Pilih Provinsi Tujuan</option>';
        Object.keys(shippingData).forEach(function (provName) {
            const option = document.createElement('option');
            option.value = provName;
            option.textContent = provName;
            provinceSelect.appendChild(option);
        });

        // ================== SAAT PROVINSI DIGANTI ==================
        provinceSelect.addEventListener('change', function () {
            const selectedProvince = this.value;
            provinceNameInput.value = selectedProvince;

            // reset kota
            citySelect.innerHTML = '<option value="">Pilih Kota Tujuan</option>';

            if (!selectedProvince || !shippingData[selectedProvince]) return;

            shippingData[selectedProvince].forEach(function (item) {
                const option = document.createElement('option');
                option.value = item.city;
                option.textContent = item.city;
                option.setAttribute('data-price', item.price);
                citySelect.appendChild(option);
            });
        });

        // ================== SAAT KOTA DIGANTI ==================
        citySelect.addEventListener('change', function () {
            const cityName = this.value;
            cityNameInput.value = cityName;
        });

        // ================== SAAT FORM "CEK ONGKIR" DI-SUBMIT ==================
        shippingForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const provinceName = provinceSelect.value;
            const cityOption = citySelect.options[citySelect.selectedIndex];
            const cityName = citySelect.value;
            const price = cityOption ? cityOption.getAttribute('data-price') : null;
            const weight = weightInput.value;
            const alamat = alamatInput.value.trim();
            const kodePos = kodePosInput.value.trim();
            const courier = 'MANUAL';

            // VALIDASI SEDERHANA
            if (!provinceName || !cityName || !price || !weight || !alamat || !kodePos) {
                alert('Harap lengkapi semua kolom sebelum melanjutkan.');
                return;
            }

            // Bersihkan hasil lama
            shippingResults.innerHTML = '';

            // Buat baris baru di tabel hasil
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${courier}</td>
                <td>Manual Reguler</td>
                <td>1-3 hari</td>
                <td>${weight} Gram</td>
                <td>Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('order.update-ongkir') }}" method="post">
                        @csrf
                        <input type="hidden" name="province" value="${provinceName}">
                        <input type="hidden" name="province_name" value="${provinceName}">
                        <input type="hidden" name="city" value="${cityName}">
                        <input type="hidden" name="city_name" value="${cityName}">
                        <input type="hidden" name="kurir" value="${courier}">
                        <input type="hidden" name="alamat" value="${alamat}">
                        <input type="hidden" name="pos" value="${kodePos}">
                        <input type="hidden" name="layanan_ongkir" value="Manual Reguler">
                        <input type="hidden" name="biaya_ongkir" value="${price}">
                        <input type="hidden" name="estimasi_ongkir" value="1-3 hari">
                        <button type="submit" class="primary-btn">Pilih Pengiriman</button>
                    </form>
                </td>
            `;

            shippingResults.appendChild(row);

            // pastikan div hasil tampil (kalau sebelumnya disembunyikan via CSS)
            const resultDiv = document.getElementById('result');
            if (resultDiv) {
                resultDiv.style.display = 'block';
            }
        });
    });
</script>


<!-- end template-->
@endsection