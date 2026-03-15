<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WilayahController;


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






