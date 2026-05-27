<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WilayahController;

use App\Http\Controllers\VendorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\LokasiTokoController;

use App\Http\Controllers\AntrianController;
use App\Models\Antrian;

use App\Models\NfcLog;
use App\Models\KartuNfc;


Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('buku', App\Http\Controllers\BukuController::class);
});

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/otp', [\App\Http\Controllers\AuthController::class, 'showOtpForm']);
Route::post('/verify-otp', [\App\Http\Controllers\AuthController::class, 'verifyOtp']);

Route::get('/pdf-sertifikat', [PdfController::class, 'sertifikat']);
Route::get('/pdf-undangan', [PdfController::class, 'undangan']);
Route::resource('barang', \App\Http\Controllers\BarangController::class)->middleware('auth');
Route::post('/barang/print', [BarangController::class, 'print'])->name('barang.print')->middleware('auth');

Route::get('/barang-js', function () {return view('barang_js.index');});
Route::get('/barang-js/datatables', function () {return view('barang_js.datatables');});
Route::get('/kota', function () {return view('kota.index');});

Route::get('/wilayah', function () {return view('wilayah.index');});
Route::get('/wilayah', [WilayahController::class, 'index']);
Route::get('/wilayah-axios', function () {return view('wilayah.axios');});
Route::get('/wilayah/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/wilayah/kota/{id}', [WilayahController::class, 'kota']);
Route::get('/wilayah/kecamatan/{id}', [WilayahController::class, 'kecamatan']);
Route::get('/wilayah/kelurahan/{id}', [WilayahController::class, 'kelurahan']);
Route::get('/pos', function () {return view('pos.index');});
Route::get('/pos-axios', function () {return view('pos.axios');});
Route::get('/cari-barang/{kode}', function ($kode) {return DB::table('barang')->where('id_barang', $kode)->first();});
Route::post('/simpan-transaksi', function(Request $req){

    $items = $req->items;
    $total = $req->total;

    $id = DB::table('penjualan')->insertGetId([
        'timestamp' => now(),
        'total' => $total
    ], 'id_penjualan');

    foreach($items as $item){
        DB::table('penjualan_detail')->insert([
            'id_penjualan' => $id,
            'id_barang' => $item['kode'],
            'jumlah' => $item['jumlah'],
            'subtotal' => $item['subtotal']
        ]);
    }

    return response()->json([
        'success' => true
    ]);
});

Route::resource('/vendor', VendorController::class);
Route::get('/vendor-dashboard', function () {return view('vendor.dashboard');});
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/create', [MenuController::class, 'create']);
Route::post('/menu', [MenuController::class, 'store']);
Route::resource('/menu', MenuController::class);
Route::get('/pesanan', [PesananController::class, 'index']);
Route::get('/vendor-dashboard', [VendorDashboardController::class, 'index']);
Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/pesan/{id}', [CustomerController::class, 'pesan']);
Route::get('/pesan/{id}', [CustomerController::class, 'formPesan']);
Route::post('/pesan', [CustomerController::class, 'storePesanan']);
Route::post('/cart/add', [CustomerController::class, 'addToCart']);
Route::get('/cart', [CustomerController::class, 'viewCart']);
Route::post('/checkout', [CustomerController::class, 'checkout']);
Route::post('/cart/remove/{id}', [CustomerController::class, 'removeCart']);
Route::post('/cart/clear', [CustomerController::class, 'clearCart']);
Route::get('/payment/success/{id}', [PaymentController::class, 'success']);
Route::get('/payment', [CustomerController::class, 'payment']);
Route::get('/pesanan/{id}', [CustomerController::class, 'detail']);

Route::prefix('admin/customer')->group(function () {
    Route::get('/', [AdminCustomerController::class, 'index']);
    Route::get('/create2', [AdminCustomerController::class, 'create2']);
    Route::post('/store2', [AdminCustomerController::class, 'store2']);
});
Route::get('/admin/customer/create1', [AdminCustomerController::class, 'create1']);
Route::post('/admin/customer/store1', [AdminCustomerController::class, 'store1']);

Route::get('/admin/barcode-scanner', function () {return view('admin.barcode_scanner');});
Route::get('/admin/barcode/get/{kode}', [BarangController::class, 'getBarcode']);

Route::get('/vendor-scan-qr', [VendorController::class, 'scanQr'])->name('vendor.scan.qr');
Route::get('/kunjungan-toko', [VendorController::class, 'kunjunganToko']);
Route::resource('vendor', VendorController::class);
Route::get('/vendor/get-pesanan/{id}', [VendorController::class, 'getPesanan']);
Route::get('/pesanan/{id}', [CustomerController::class, 'detail']);

Route::get('/kunjungan-toko', [LokasiTokoController::class, 'index']);
Route::post('/kunjungan-toko/store', [LokasiTokoController::class, 'store']);
Route::get('/barcode-toko/{barcode}', [LokasiTokoController::class, 'barcode']);
Route::get('/kunjungan-toko/{barcode}', [VendorController::class, 'scanToko']);


Route::get('/guest', [AntrianController::class, 'guest']);
Route::post('/guest/store', [AntrianController::class, 'store']);
Route::get('/sse/antrian', function () {

    return response()->json([

        'menunggu' => Antrian::where('status', 'menunggu')->count(),
        'dipanggil' => Antrian::where('status', 'dipanggil')->count(),
        'terlambat' => Antrian::where('status', 'terlambat')->count(),
        'selesai' => Antrian::where('status', 'selesai')->count(),

        'loket1' => optional(
            Antrian::where('poli', 'Poli Umum')
            ->where('status', 'dipanggil')
            ->latest()
            ->first()
        )->kode_antrian ?? '-',

        'loket2' => optional(
            Antrian::where('poli', 'Poli Gigi')
            ->where('status', 'dipanggil')
            ->latest()
            ->first()
        )->kode_antrian ?? '-',

        'loket3' => optional(
            Antrian::where('poli', 'Poli Anak')
            ->where('status', 'dipanggil')
            ->latest()
            ->first()
        )->kode_antrian ?? '-',

        'loket4' => optional(
            Antrian::where('poli', 'Poli Jantung')
            ->where('status', 'dipanggil')
            ->latest()
            ->first()
        )->kode_antrian ?? '-',

        'loket5' => optional(
            Antrian::where('poli', 'Poli Kandungan')
            ->where('status', 'dipanggil')
            ->latest()
            ->first()
        )->kode_antrian ?? '-',

        'antrians' => Antrian::latest()->get(),

        'next1' => optional(
            Antrian::where('status', 'menunggu')
            ->where('poli', 'Poli Umum')
            ->first()
        )->id,

        'next2' => optional(
            Antrian::where('status', 'menunggu')
            ->where('poli', 'Poli Gigi')
            ->first()
        )->id,

        'next3' => optional(
            Antrian::where('status', 'menunggu')
            ->where('poli', 'Poli Anak')
            ->first()
        )->id,

        'next4' => optional(
            Antrian::where('status', 'menunggu')
            ->where('poli', 'Poli Jantung')
            ->first()
        )->id,

        'next5' => optional(
            Antrian::where('status', 'menunggu')
            ->where('poli', 'Poli Kandungan')
            ->first()
        )->id,

        'next1' => optional(
            Antrian::where('poli', 'Poli Umum')
            ->where('status', 'menunggu')
            ->first()
        )->kode_antrian ?? '-',

        'next2' => optional(
            Antrian::where('poli', 'Poli Gigi')
            ->where('status', 'menunggu')
            ->first()
        )->kode_antrian ?? '-',

        'next3' => optional(
            Antrian::where('poli', 'Poli Anak')
            ->where('status', 'menunggu')
            ->first()
        )->kode_antrian ?? '-',

        'next4' => optional(
            Antrian::where('poli', 'Poli Jantung')
            ->where('status', 'menunggu')
            ->first()
        )->kode_antrian ?? '-',

        'next5' => optional(
            Antrian::where('poli', 'Poli Kandungan')
            ->where('status', 'menunggu')
            ->first()
        )->kode_antrian ?? '-',
    ]);
});
Route::get('/admin-dashboard', function () {$antrians = Antrian::latest()->get();return view('adminrs.dashboard', compact('antrians'));});
Route::post('/panggil/{id}/{loket}', function ($id, $loket) {
    $antrian = Antrian::find($id);
    $antrian->update([
        'status' => 'dipanggil',
        'loket' => $loket
    ]);
    return back();
});
Route::post('/status/{id}/{status}', function ($id, $status) {
    $antrian = Antrian::find($id);
    $loket = match($antrian->poli){
        'Poli Umum' => 1,
        'Poli Gigi' => 2,
        'Poli Anak' => 3,
        'Poli Jantung' => 4,
        'Poli Kandungan' => 5,
    };
    $antrian->update([
        'status' => $status,
        'loket' => $loket,
        'updated_at' => now()
    ]);
    return back();
});
Route::get('/reset-antrian', function () {\App\Models\Antrian::truncate();return redirect('/admin-dashboard');});
Route::get('/papan-antrian', function () {return view('antrian.papan-antrian');});



Route::get('/nfc', function () {return view('nfc.index');});
Route::post('/nfc/store', function(Request $request){
    NfcLog::create([
        'serial_number' => $request->serial_number,
        'scan_time' => now()
    ]);

    return response()->json([
        'success' => true
    ]);
});
Route::post('/nfc/save', [HomeController::class, 'saveNfc']);
Route::post('/nfc/register', [HomeController::class, 'registerNfc']);
Route::post('/nfc/register', function(Request $request){
    KartuNfc::create([
        'nama' => $request->nama,
        'serial_number' => $request->serial_number
    ]);

    return response()->json([
        'message' => 'Kartu berhasil didaftarkan'
    ]);

});
Route::post('/nfc/check', function(Request $request){
    $kartu = KartuNfc::where(
        'serial_number',
        $request->serial_number
    )->first();

    if($kartu){
        return response()->json([
            'success' => true,
            'nama' => $kartu->nama
        ]);
    }

    return response()->json([
        'success' => false
    ]);
});
Route::get('/nfc/riwayat', function () {$logs = NfcLog::latest()->get();return view('nfc.riwayat', compact('logs'));});
Route::post('/nfc/save', function(Request $request){
    $kartu = KartuNfc::where(
        'serial_number',
        $request->serial_number
    )->first();

    NfcLog::create([
        'nama' => $kartu ? $kartu->nama : 'Tidak Dikenal',
        'serial_number' => $request->serial_number,
        'scan_time' => now()
    ]);

    return response()->json([
        'success' => true
    ]);
});