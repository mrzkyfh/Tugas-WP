<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Produk;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    /**
     * Helper: ambil atau buat record customer untuk user yang sedang login
     */
    protected function getOrCreateCustomer()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        return Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                // sesuaikan dengan kolom yang ada di tabel customers
                'google_id'    => null,
                'google_token' => null,
            ]
        );
    }

    public function addToCart($id)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Pastikan customer ada (kalau belum, dibuat)
        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        // Ambil produk
        $produk = Produk::findOrFail($id);

        // Ambil / buat order dengan status pending milik customer
        $order = Order::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => 'pending'],
            ['total_harga' => 0]
        );

        // Ambil / buat item di order
        $orderItem = OrderItem::firstOrCreate(
            ['order_id' => $order->id, 'produk_id' => $produk->id],
            ['quantity' => 0, 'harga' => $produk->harga]
        );

        // Tambah quantity 1
        $orderItem->quantity += 1;
        $orderItem->save();

        // Update total harga order
        $order->total_harga += $produk->harga;
        $order->save();

        return redirect()->route('order.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        // Kalau belum ada order, kirim null ke view (keranjang kosong)
        if (!$order) {
            return view('v_order.cart', ['order' => null]);
        }

        $order->load('orderItems.produk');

        return view('v_order.cart', compact('order'));
    }

    public function updateCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $orderItem = $order->orderItems()->where('id', $id)->first();
            if ($orderItem) {
                $quantity = (int) $request->input('quantity', 1);

                if ($quantity > $orderItem->produk->stok) {
                    return redirect()->route('order.cart')
                        ->with('error', 'Jumlah produk melebihi stok yang tersedia');
                }

                // Kurangi total harga lama
                $order->total_harga -= $orderItem->harga * $orderItem->quantity;

                // Update quantity baru
                $orderItem->quantity = $quantity;
                $orderItem->save();

                // Tambah total harga baru
                $order->total_harga += $orderItem->harga * $orderItem->quantity;
                $order->save();
            }
        }

        return redirect()->route('order.cart')->with('success', 'Jumlah produk berhasil diperbarui');
    }

    public function removeFromCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $orderItem = OrderItem::where('order_id', $order->id)
                ->where('produk_id', $id)
                ->first();

            if ($orderItem) {
                $order->total_harga -= $orderItem->harga * $orderItem->quantity;
                $orderItem->delete();

                if ($order->total_harga <= 0) {
                    $order->delete();
                } else {
                    $order->save();
                }
            }
        }

        return redirect()->route('order.cart')->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function selectShipping(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('order.cart')->with('error', 'Keranjang belanja kosong.');
        }

        $order->load('orderItems.produk');

        return view('v_order.select_shipping', compact('order'));
    }

    public function updateOngkir(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $origin     = $request->input('city_origin');
            $originName = $request->input('city_origin_name');

            $order->kurir          = $request->input('kurir');
            $order->layanan_ongkir = $request->input('layanan_ongkir');
            $order->biaya_ongkir   = $request->input('biaya_ongkir');
            $order->estimasi_ongkir = $request->input('estimasi_ongkir');
            $order->total_berat    = $request->input('total_berat');
            $order->alamat         = $request->input('alamat') . ', <br>' .
                                     $request->input('city_name') . ', <br>' .
                                     $request->input('province_name');
            $order->pos            = $request->input('pos');
            $order->save();

            return redirect()->route('order.selectpayment')
                ->with('origin', $origin)
                ->with('originName', $originName);
        }

        return back()->with('error', 'Gagal menyimpan data ongkir');
    }

    public function selectPayment()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        $origin     = session('origin');
        $originName = session('originName');

        if (!$order) {
            return redirect()->route('order.cart')->with('error', 'Keranjang belanja kosong.');
        }

        $order->load('orderItems.produk');

        // Hitung total harga produk
        $totalHarga = 0;
        foreach ($order->orderItems as $item) {
            $totalHarga += $item->harga * $item->quantity;
        }

        $grossAmount = $totalHarga + (int) $order->biaya_ongkir;

        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $orderId = $order->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'      => $orderId,
                'gross_amount'  => (int) $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email'      => $user->email,
                'phone'      => $user->hp ?? null,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('v_order.select_payment', [
            'order'      => $order,
            'origin'     => $origin,
            'originName' => $originName,
            'snapToken'  => $snapToken,
        ]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $order = Order::find($request->order_id);
            if ($order) {
                $order->update(['status' => 'Paid']);
            }
        }
    }

    public function complete()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if ($customer) {
            $order = Order::where('customer_id', $customer->id)
                ->where('status', 'pending')
                ->first();

            if ($order) {
                $order->status = 'Paid';
                $order->save();
            }
        }

        return redirect()->route('order.history')->with('success', 'Checkout berhasil');
    }

    public function orderHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $this->getOrCreateCustomer();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data customer.');
        }

        $statuses = ['Paid', 'Kirim', 'Selesai'];

        $orders = Order::where('customer_id', $customer->id)
            ->whereIn('status', $statuses)
            ->orderBy('id', 'desc')
            ->get();

        return view('v_order.history', compact('orders'));
    }

    public function invoiceFrontend($id)
    {
        $order = Order::findOrFail($id);

        return view('v_order.invoice', [
            'judul'    => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
            'order'    => $order,
        ]);
    }
}
