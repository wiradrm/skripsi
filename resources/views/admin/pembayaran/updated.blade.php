@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pembayaran</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pinjaman</h6>
    </div>


    <form action="{{route('pembayaran.update', $hutang->no_pinjam)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <input type="text" name="no_pinjam" value="{{$item->no_pinjam}}" hidden>
            <input type="text" name="id_nasabah" value="{{$item->id_nasabah}}" hidden>
            <div class="form-group">
                <label for="name" class="col-form-label">Pinjaman</label> <br>
                <b>
                    <span>{{ $item->no_pinjam }} | {{$item->nasabah->nama}}</span>
                </b>
            </div>
            <div class="form-group">
                <label for="name" class="col-form-label">Sisa Hutang</label> <br>
                <b>
                    <input type="text" id="jumlahHutang" name="hutang" value="{{$item->hutang}}" hidden>
                    <input type="text" id="persenBunga" name="persen" value="{{$item->bunga}}" hidden>
                    <span>@currency($item->hutang)</span>
                </b>
            </div>
            <div class="form-group">
                <label for="updateJumlah" class="col-form-label">Jumlah Bayar</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">Rp.</div>
                    </div>
                    <input type="number" class="form-control" id="updateJumlah" name="jumlah">
                  </div>
            </div>
            <b>
                <p for="rincian">Rincian</p>
                <p style="color: red">Minimal membayar bunga</p>
                <p>Bunga : <span id="bunga">0</span></p>
                <p id="subtotalWrapper">Pokok : <span id="pokok">0</span></p>
                <p>Sisa Hutang : <span id="sisa">0</span></p>
            </b>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
        
    </div>
</div>



@endsection
@section('script')
<script>

        $(document).ready(function() {
            $("#updateJumlah").on("input", function() {
                var hutang = $("#jumlahHutang").val();
                var bunga = $("#persenBunga").val();
                var pokok
                var jumlahBunga
                var sisaHutang
                
                jumlahBunga = hutang * bunga / 100
                
                
                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(jumlahBunga);
                $("#bunga").text(output);

                pokok = $(this).val() - jumlahBunga

                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(pokok);
                $("#pokok").text(output);

                sisaHutang = hutang - pokok 

                var output = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(sisaHutang);
                $("#sisa").text(output);
            });
        });

</script>
@endsection




