@extends('backend.v_layouts.app')

@section('content')
    {{-- STYLE KHUSUS BERANDA --}}
    <style>
        .dashboard-welcome {
            border-radius: 18px;
            overflow: hidden;
            border: none;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            background: #0f172a;
            color: #e5e7eb;
            margin-top: 10px;
        }

        .dashboard-welcome-header {
            padding: 18px 24px;
            background: radial-gradient(circle at top left, #1d4ed8, #0f172a);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dashboard-title {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .dashboard-role-badge {
            border-radius: 999px;
            padding: 6px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            background: rgba(15, 23, 42, 0.25);
            border: 1px solid rgba(191, 219, 254, 0.5);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .dashboard-role-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #22c55e;
        }

        .dashboard-welcome-body {
            padding: 22px 24px 18px;
            background: #0b1220;
        }

        .dashboard-greeting {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #f9fafb;
        }

        .dashboard-subtext {
            font-size: 13px;
            color: #9ca3af;
        }

        .dashboard-highlight {
            margin-top: 16px;
            padding: 14px 16px;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.9);
            border: 1px dashed rgba(148, 163, 184, 0.7);
            font-size: 12px;
            color: #e5e7eb;
        }

        .dashboard-welcome-footer {
            padding: 12px 24px 14px;
            background: #020617;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #6b7280;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-footer-brand {
            color: #93c5fd;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .dashboard-welcome-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .dashboard-welcome-body {
                padding: 18px 16px 14px;
            }
            .dashboard-welcome-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="dashboard-welcome">
                {{-- HEADER --}}
                <div class="dashboard-welcome-header">
                    <div>
                        <div class="dashboard-title">{{ $judul ?? 'Beranda' }}</div>
                        <small style="font-size: 11px; opacity: .8;">
                            Ringkasan singkat aplikasi Toko Online Anda
                        </small>
                    </div>
                    <div class="dashboard-role-badge">
                        <span class="dashboard-role-dot"></span>
                        <span>
                            @if (Auth::user()->role == 1)
                                Super Admin
                            @elseif (Auth::user()->role == 0)
                                Admin
                            @else
                                Pengguna
                            @endif
                        </span>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="dashboard-welcome-body">
                    <div class="dashboard-greeting">
                        Selamat Datang, {{ Auth::user()->nama }}
                    </div>
                    <p class="dashboard-subtext">
                        Anda sedang berada di halaman utama panel administrasi
                        <strong>Toko Online</strong>. Dari sini Anda dapat mengelola customer,
                        produk, transaksi, dan laporan penjualan.
                    </p>

                    <div class="dashboard-highlight">
                        <strong>Tips cepat:</strong> gunakan menu di sisi kiri untuk
                        menambahkan produk baru, memperbarui stok, dan melihat laporan
                        penjualan harian. Pastikan data selalu up to date agar proses
                        transaksi berjalan lancar.
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="dashboard-welcome-footer">
                    <span>Dashboard Admin Toko Online</span>
                    <span class="dashboard-footer-brand">
                        Web Programming · Studi Kasus Toko Online
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
