<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::where('is_active', true)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($l) {
                return [
                    'nama'   => $l->nama,
                    'alamat' => $l->alamat,
                    'lat'    => (float) $l->lat,
                    'lng'    => (float) $l->lng,
                ];
            });

        return view('v_produk.lokasi', compact('lokasi'));
    }

}
