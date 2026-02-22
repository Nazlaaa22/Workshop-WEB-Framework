<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function sertifikat()
    {
        $data = [
            'nama' => 'Nazlatul Khoiriyah',
            'jabatan' => 'Wakil Ketua Pelaksana',
            'tanggal' => '18 Oktober 2025'
        ];

        $pdf = Pdf::loadView('pdf.sertifikat', $data)
            ->setPaper('A4', 'landscape');

        return $pdf->download('sertifikat.pdf');
    }

    public function undangan()
    {
        $data = [
            'tanggal_surat' => '13 Januari 2026'
        ];

        $pdf = Pdf::loadView('pdf.undangan', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('undangan.pdf');
    }
}