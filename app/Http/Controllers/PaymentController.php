<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function payment()
    {
        $pesanan = \App\Models\Pesanan::latest('idpesanan')->first();

        if (!$pesanan) {
            return "Belum ada pesanan!";
        }

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->idpesanan,
                'gross_amount' => $pesanan->total,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama,
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('customer.payment', compact('pesanan', 'snapToken'));
    }

    public function success($id)
    {
        $pesanan = Pesanan::find($id);

        $pesanan->status_bayar = 1; 
        $pesanan->save();

        return view('customer.success', compact('pesanan'));
    }
}