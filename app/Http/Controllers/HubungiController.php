<?php

namespace App\Http\Controllers;

class HubungiController extends Controller
{
    public function index()
    {
        // Bisa kamu ubah sesuai toko kamu
        $kontak = [
            'nama'   => 'Toko Komputer',
            'alamat' => 'jalan kenangan mantan nomor 12 kecamatan terindah desa kesana kesini',
            'wa'     => '62812340000000', // format WA wajib 62...
            'telp'   => '0812-000-000',
            'email'  => 'tokokomputer@gmail.com',
            'ig'     => 'tokokomputer',
        ];

        return view('v_produk.hubungi', compact('kontak'));
    }
}
