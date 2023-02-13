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
                        <th>Biaya Admin</th>
                        <th>Pokok</th>
                        <th>Bunga</th>
                        <th>Action</th>
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
                        <td>@currency($item->administrasi)</td>
                        <td>@currency($item->pokok)</td>
                        <td>@currency($item->bunga)</td>
                        <td>
                            <a class="btn btn-circle btn-info mx-1" target="__blank" href="{{route('laporan.buktibayar',$item->id)}}"><i class='bx bxs-printer'></i></a>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
    </div>
</div>

@endsection
@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
<script type="text/javascript">
	$("#myForm").ready(function(){
	    // Format mata uang.
	    $( "#uang" ).mask('0.000.000.000', {reverse: true, autoUnmask: true});

        
	})

    $("#myForm").submit(function() {
            $("#uang").unmask();
        });

</script>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    // Format mata uang.
	    $( '.uang' ).mask('0.000.000.000', {reverse: true});
	})
</script> --}}
<script>
    

        // $(document).ready(function() {
        //     $("#updateJumlah").on("input", function() {
        //         var hutang = $("#jumlahHutang").val();
        //         var bunga = $("#persenBunga").val();
        //         var pokok
        //         var jumlahBunga
        //         var sisaHutang
                
        //         jumlahBunga = hutang * bunga / 100
                
                
        //         var output = new Intl.NumberFormat("id-ID", {
        //             style: "currency",
        //             currency: "IDR"
        //         }).format(jumlahBunga);
        //         $("#bunga").text(output);

        //         pokok = $(this).val() - jumlahBunga

        //         var output = new Intl.NumberFormat("id-ID", {
        //             style: "currency",
        //             currency: "IDR"
        //         }).format(pokok);
        //         $("#pokok").text(output);

        //         sisaHutang = hutang - pokok 

        //         var output = new Intl.NumberFormat("id-ID", {
        //             style: "currency",
        //             currency: "IDR"
        //         }).format(sisaHutang);
        //         $("#sisa").text(output);
        //     });
        // });

         /* Tanpa Rupiah */
    // var tanpa_rupiah = document.getElementById('updateJumlah');
    // tanpa_rupiah.addEventListener('keyup', function(e)
    // {
    //     tanpa_rupiah.value = formatRupiah(this.value);
    // });
    
    
    // /* Fungsi */
    // function formatRupiah(angka, prefix)
    // {
    //     var number_string = angka.replace(/[^,\d]/g, '').toString(),
    //         split    = number_string.split(','),
    //         sisa     = split[0].length % 3,
    //         rupiah     = split[0].substr(0, sisa),
    //         ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
    //     if (ribuan) {
    //         separator = sisa ? '.' : '';
    //         rupiah += separator + ribuan.join('.');
    //     }
        
    //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    //     return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    // }

</script>
@endsection




