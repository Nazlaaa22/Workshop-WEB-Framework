<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Midtrans\Config;
use Midtrans\Snap;

class CustomerController extends Controller
{
    public function index()
    {
        $menu = Menu::all();
        return view('customer.menu', compact('menu'));
    }

    public function addToCart(Request $request)
    {
        $menu = Menu::find($request->idmenu);

        if (!$menu) {
            return back()->with('error', 'Menu tidak ditemukan');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$menu->idmenu])) {
            $cart[$menu->idmenu]['jumlah'] += $request->jumlah;
        } else {
            $cart[$menu->idmenu] = [
                "nama" => $menu->nama_menu,
                "harga" => $menu->harga,
                "jumlah" => $request->jumlah,
                "gambar" => $menu->path_gambar
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Ditambahkan ke keranjang!');
    }

    public function viewCart()
    {
        $cart = session('cart', []);
        return view('customer.cart', compact('cart'));
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $count = Pesanan::count() + 1;
        $nama = 'Holic_' . str_pad($count, 3, '0', STR_PAD_LEFT);

        // SIMPAN PESANAN
        $pesanan = Pesanan::create([
            'nama' => $nama,
            'total' => $total,
            'status_bayar' => 0
        ]);

        // SIMPAN DETAIL
        foreach ($cart as $idmenu => $item) {
            DetailPesanan::create([
                'idmenu' => $idmenu,
                'idpesanan' => $pesanan->idpesanan,
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah']
            ]);
        }

        session()->forget('cart');

        return redirect('/payment');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan');
    }

    public function payment()
    {
        $pesanan = Pesanan::orderBy('idpesanan', 'desc')->first();
        return view('customer.payment', compact('pesanan'));
    }

    public function processPayment(Request $request)
    {
        $pesanan = Pesanan::find($request->idpesanan);

        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan');
        }

        $pesanan->update([
            'status_bayar' => 1
        ]);

        return redirect('/customer')->with('success', 'Pembayaran berhasil!');
    }

    public function snapToken()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $pesanan = Pesanan::orderBy('idpesanan', 'desc')->first();

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->idpesanan,
                'gross_amount' => $pesanan->total,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json($snapToken);
    
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $hashed = hash("sha512", 
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed == $request->signature_key) {

            $pesanan = Pesanan::find($request->order_id);

            if ($request->transaction_status == 'settlement') {
                $pesanan->update([
                    'status_bayar' => 1
                ]);
            }
        }

        return response()->json(['message' => 'ok']);
    }

    public function process(Request $request)
    {
        $pesanan = Pesanan::find($request->idpesanan);

        $pesanan->status_bayar = 'lunas';
        $pesanan->save();

        return redirect('/dashboard');
    }

    public function riwayat()
    {
        $pesanan = \App\Models\Pesanan::where('user_id', auth()->id())->get();

        return view('customer.riwayat', compact('pesanan'));
    }
}