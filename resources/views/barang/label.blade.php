<!DOCTYPE html>
<html>
<head>
<style>
@page { margin: 10mm; }

body { font-family: Arial; }

table { width: 100%; border-collapse: collapse; }

td {
    width: 20%;
    height: 80px;
    text-align: center;
    vertical-align: middle;
}

.nama { font-size: 12px; font-weight: bold; }
.harga { font-size: 14px; }
</style>
</head>
<body>

@php
$totalSlot = 40;
$barangIndex = 0;
@endphp

<table>

@for($row = 0; $row < 8; $row++)
<tr>

    @for($col = 0; $col < 5; $col++)

        @php
            $slot = ($row * 5) + $col;
        @endphp

        <td>

            {{-- Kalau slot sudah melewati startPosition --}}
            @if($slot >= $startPosition && $barangIndex < count($barang))
                <div class="nama">
                    {{ $barang[$barangIndex]->nama_barang }}
                </div>
                <div class="harga">
                    Rp {{ number_format($barang[$barangIndex]->harga,0,',','.') }}
                </div>
                @php $barangIndex++; @endphp
            @endif

        </td>

    @endfor

</tr>
@endfor

</table>

</body>
</html>