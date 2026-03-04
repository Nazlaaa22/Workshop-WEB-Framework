<!DOCTYPE html>
<html>
<head>
<style>
@page {
    margin: 0;
}

body {
    margin: 0;
    padding: 0.5cm;
    font-family: Arial, sans-serif;
}

table {
    border-collapse: collapse;
}

td {
    width: 3.8cm;
    height: 1.8cm;
    border: 1px solid #e6e28a;
    text-align: center;
    vertical-align: middle;
    padding: 0px;
}

.nama {
    font-size: 10px;
    font-weight: bold;
}

.harga {
    font-size: 10px;
}
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