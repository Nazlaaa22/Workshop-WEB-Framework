<form action="{{ route('barang.print') }}" method="POST">
    @csrf

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $b)
            <tr>
                <td>
                    <input type="checkbox" name="barang_ids[]" value="{{ $b->id_barang }}">
                </td>
                <td>{{ $b->id_barang }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>Rp {{ number_format($b->harga,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row mt-3">
        <div class="col-md-2">
            <label>X (Kolom)</label>
            <input type="number" name="start_x" min="1" max="5" class="form-control" required>
        </div>

        <div class="col-md-2">
            <label>Y (Baris)</label>
            <input type="number" name="start_y" min="1" max="8" class="form-control" required>
        </div>
    </div>

    <button type="submit" class="btn btn-success mt-3">
        Cetak Label
    </button>
</form>