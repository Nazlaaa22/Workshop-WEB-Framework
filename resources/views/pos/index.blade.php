@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">POS AJAX</h3>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label>Kode Barang</label>
                <input type="text" id="kode_barang" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label>Nama Barang</label>
                <input type="text" id="nama_barang" class="form-control" readonly>
            </div>
            
            <div class="col-md-6 mt-3">
                <label>Harga</label>
                <input type="text" id="harga_barang" class="form-control" readonly>
            </div>
            
            <div class="col-md-6 mt-3">
                <label>Jumlah</label>
                <input type="number" id="jumlah" class="form-control" value="1">
            </div>
        </div>
        
        <button class="btn btn-success mt-3" id="btnTambah">
            Tambahkan
        </button>
        
        <hr>
        <table class="table table-bordered" id="tablePOS">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
        
        <h4>Total : <span id="total">0</span></h4>
        <button class="btn btn-primary mt-2" id="btnBayar">
            Bayar
        </button>
    </div>
</div>

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){
        let items=[]
        let total=0

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ENTER cari barang
        $("#kode_barang").keypress(function(e){
            if(e.which==13){
                e.preventDefault()
                let kode=$(this).val()
                $.get('/cari-barang/'+kode,function(data){
                    $("#nama_barang").val(data.nama_barang)
                    $("#harga_barang").val(data.harga)
                    $("#jumlah").val(1)
                })
            }
        })

        // tambah barang
        $("#btnTambah").click(function(){
            let kode=$("#kode_barang").val()
            let nama=$("#nama_barang").val()
            let harga=parseInt($("#harga_barang").val())
            let jumlah=parseInt($("#jumlah").val())
            if(jumlah<=0)return
            let subtotal=harga*jumlah

            // cek barang sama
            let existing=items.find(i=>i.kode==kode)
            if(existing){
                existing.jumlah+=jumlah
                existing.subtotal=existing.jumlah*harga
            }else{
                items.push({
                    kode,nama,harga,jumlah,subtotal
                })
            }
            renderTable()
        })

        function renderTable(){
            $("#tablePOS tbody").html('')
            total=0
            items.forEach((item,index)=>{
                total+=item.subtotal
                let row=`
                <tr>
                    <td>${item.kode}</td>
                    <td>${item.nama}</td>
                    <td>${item.harga}</td>
                    <td>${item.jumlah}</td>
                    <td>${item.subtotal}</td>
                
                    <td>
                        <button class="btn btn-danger btnHapus" data-index="${index}">
                            Hapus
                        </button>
                    </td>
                </tr>
                `
                $("#tablePOS tbody").append(row)
            })
            $("#total").text(total)
        }


        // hapus
        $(document).on("click",".btnHapus",function(){
            let i=$(this).data("index")
            items.splice(i,1)
            renderTable()
        })


        // bayar
        $("#btnBayar").click(function(){
            if(items.length==0){
                Swal.fire({
                    icon:'warning',
                    title:'Tidak ada transaksi'
                })
                return
            }

            $.ajax({
                url:'/simpan-transaksi',
                method:'POST',
                data:{
                    items:items,
                    total:total
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                
                success:function(res){
                    Swal.fire({
                        icon:'success',
                        title:'Transaksi berhasil disimpan'
                    })
                    items=[]
                    renderTable()
                    $("#kode_barang").val('')
                    $("#nama_barang").val('')
                    $("#harga_barang").val('')
                    $("#jumlah").val(1)
                },
                
                error:function(err){
                    console.log(err)
                    Swal.fire({
                        icon:'error',
                        title:'Gagal menyimpan transaksi'
                    })
                }
            })

        })
    })

</script>

@endsection
