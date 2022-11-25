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
    <div class="card-body">
        @if (\Session::has('info'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! \Session::get('info') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (\Session::has('msg'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! \Session::get('msg') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif


        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="my-0 px-4">
                @foreach ($errors->all() as $error)
                <li class="my-0">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Pinjam</th>
                        <th>Nama</th>
                        <th>Sisa Hutang</th>
                        <th>Bunga Menurun</th>
                        <th width="7%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($models->count() == 0)
                    <tr>
                        <td colspan="100%" align="center">
                            No data
                        </td>
                    </tr>
                    @endif
                    @foreach($models as $key => $item)
                    <tr>
                        <td>{{ $item->no_pinjam }}</td>
                        <td>{{ $item->nasabah->nama }}</td>
                        <td>@currency($item->hutang)</td>
                        <td>{{ $item->bunga }}%</td>
    
                        <td>
                            <a class="btn btn-success mx-1" href="#" data-toggle="modal" data-target="#updateModal-{{$item->no_pinjam}}" style="font-family: nunito">Bayar</a>
                            @include('admin.pembayaran.update')
                        </td>
    
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Pinjam</th>
                        <th>Nama</th>
                        <th>Tanggal Bayar</th>
        
                        <th>Jumlah</th>
                        <th>Pokok</th>
                        <th>Bunga</th>
                    </tr>
                </thead>
                <tbody>
                    @if($datas->count() == 0)
                    <tr>
                        <td colspan="100%" align="center">
                            No data
                        </td>
                    </tr>
                    @endif
                    @foreach($datas as $key => $item)
                    <tr>
                        <td>{{ $item->no_pinjam }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td>@currency($item->jumlah)</td>
                        <td>@currency($item->pokok)</td>
                        <td>@currency($item->bunga)</td>
        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
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




